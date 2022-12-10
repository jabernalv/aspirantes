<?php

namespace frontend\controllers;

use Yii;
use common\models\AspiranteCargo;
use common\models\search\AspiranteCargoSearch;
use common\models\Cargo;
use common\models\search\CargoSearch;
use common\models\OpcionCargo;
use common\models\EstadoAspiranteProceso;
use common\models\Proceso;
use common\models\ArchivoAspiranteCargo;
use common\models\ArchivoAspirante;
use common\models\PinProceso;
use common\helpers\SeleccionHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * AspirantecargoController implements the CRUD actions for AspiranteCargo model.
 */
class AspirantecargoController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'update', 'view', 'create'],
                'rules' => [
                    [
                        'actions' => ['index', 'update', 'view', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all AspiranteCargo models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AspiranteCargoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['aspirante_uuid' => Yii::$app->user->identity->uuid]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AspiranteCargo model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = AspiranteCargo::find()
                ->innerJoin('cargo', 'cargo.id=aspirante_cargo.cargo_id')
                ->where(['aspirante_cargo.aspirante_uuid' => Yii::$app->user->identity->uuid, 'cargo.proceso_id' => $id])
                ->one();
        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }/**/
        return $this->render('view', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new AspiranteCargo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $id Identificador del proceso
     * @return mixed
     */
    public function actionCreate($id) {
        /* Se verifica que el proceso esté activo y la fecha de fin de aplicación no haya terminado */
        $proceso = Proceso::find()->where(['id' => $id, 'activo' => 1])->andWhere(['>', 'fecha_fin_aplicacion', date("Y-m-d")])->one();
        if (is_null($proceso)) {
            return $this->redirect(['/aspirante/index']);
        }
        $model = new AspiranteCargo();
        /* Se asigna el uuid del usuario que está autenticado */
        $model->aspirante_uuid = Yii::$app->user->identity->uuid;
        if ($model->load(Yii::$app->request->post())) { // Si se está devolviendo la información en POST
            /* Se verifica que el proceso esté abierto */
            if ($model->cargo->proceso->activo == 1 && $model->cargo->proceso->fecha_fin_aplicacion > date("Y-m-d")) {
                /* Se verifica que el cargo seleccionado corresponda al proceso */
                $cargo = Cargo::findOne($model->cargo_id);
                if ($cargo->proceso_id == $id) {
                    /* Se verifica que la opción seleccionada corresponda al cargo */
                    $opcion = OpcionCargo::findOne($model->opcion_cargo_id);
                    if ($opcion->cargo_id == $cargo->id) {
                        $pin_existe = true;
                        $pin_valido = true;
                        $pinproceso = new PinProceso();
                        if ($proceso->requiere_pin) {
                            $pinproceso = PinProceso::find()->where(['proceso_id' => $proceso->id, 'pin' => $model->pin_proceso_uuid])->one();
                            if (is_null($pinproceso)) {
                                $pin_existe = false;
                            } else {
                                if ($pinproceso->usado != 0) {
                                    $pin_valido = false;
                                } else {
                                    $model->pin_proceso_uuid = $pinproceso->uuid;
                                }
                            }
                        } else {
                            $model->pin_proceso_uuid = null;
                        }
                        if ($pin_existe) {
                            if ($pin_valido) {
                                $model->uuid = Yii::$app->session->get('nuevoaspirantecargouuid');
                                $model->estado_id = EstadoAspiranteProceso::find()->where(['proceso_id' => $id])->orderBy('id')->one()->id;
                                if ($model->save()) {
                                    foreach (Yii::$app->request->post()['AspiranteCargo']['archivo_aspirantes'] as $key => $value) {
                                        $archivo_aspirante = ArchivoAspirante::findOne($value);
                                        $sp = new ArchivoAspiranteCargo();
                                        $sp->uuid = SeleccionHelper::uuid();
                                        $sp->aspirante_cargo_uuid = $model->uuid;
                                        $sp->archivo_aspirante_uuid = $value;
                                        $sp->comentarios_aspirante = $archivo_aspirante->comentarios_aspirante;
                                        $sp->tenido_en_cuenta = 0;
                                        $sp->save();
                                    }
                                    if ($proceso->requiere_pin) {
                                        $pinproceso->usado = 1;
                                        $pinproceso->save();
                                    }
                                    Yii::$app->session->remove('nuevoaspirantecargouuid');
                                    return $this->redirect(['view', 'id' => $model->cargo->proceso_id]);
                                } else {
                                    Yii::$app->session->setFlash('error', 'Ha ocurrido un error al guardar.' . print_r($model->errors, true));
                                }
                            } else {
                                Yii::$app->session->setFlash('error', 'El pin ingresado ya ha sido utilizado.');
                            }
                        } else {
                            Yii::$app->session->setFlash('error', 'El pin ingresado no existe.');
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Ha seleccionado una opción que no corresponde al cargo escogido.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'El cargo al que intenta aplicar no es del proceso solicitado.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Está tratando de aplicar a un proceso que no está activo.');
            }
        }
        $searchModelCargo = new CargoSearch();
        $dataProviderCargo = $searchModelCargo->search([]);
        $dataProviderCargo->query->andWhere(['proceso_id' => $id]);
        $dataProviderCargo->pagination = false;
        Yii::$app->session->set('nuevoaspirantecargouuid', Helper::uuid());
        //$model->cargo_id = 0;
        return $this->render('create', [
                    'searchModelCargo' => $searchModelCargo,
                    'dataProviderCargo' => $dataProviderCargo,
                    'model' => $model,
                    'proceso' => $proceso,
        ]);
    }

    /**
     * Updates an existing AspiranteCargo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($uuid) {
        $model = $this->findModel($uuid);
        $modelForm = new AspiranteCargo();
        $proceso = $model->cargo->proceso;
        if ($proceso->activo == 0 || $proceso->fecha_fin_aplicacion < date("Y-m-d")) {
            return $this->redirect(['view', 'id' => $proceso->id]);
        }
        if ($modelForm->load(Yii::$app->request->post())) { // Si se está devolviendo la información en POST
            /* Se verifica que el proceso esté abierto */
            if ($modelForm->cargo->proceso->activo == 1 && $model->cargo->proceso->fecha_fin_aplicacion > date("Y-m-d")) {
                /* Se verifica que el cargo seleccionado corresponda al proceso */
                $cargo = Cargo::findOne($modelForm->cargo_id);
                if ($cargo->proceso_id == $model->cargo->proceso_id) {
                    /* Se verifica que la opción seleccionada corresponda al cargo */
                    $opcion = OpcionCargo::findOne($modelForm->opcion_cargo_id);
                    if ($opcion->cargo_id == $cargo->id) {
                        // El pin no se debe poder cambiar
                        $model->cargo_id = $modelForm->cargo_id;
                        $model->opcion_cargo_id = $modelForm->opcion_cargo_id;
                        $archivo_aspirantesincluidos = explode(',', $model->archivo_aspirantes_seleccionados);
                        $model->numero_archivo_aspirantes = count($archivo_aspirantesincluidos);
                        if ($model->save()) {
                            $archivo_aspirantesparaborrar = ArchivoAspiranteCargo::find()
                                    ->where(['aspirante_cargo_uuid' => $model->uuid])
                                    ->andWhere(['not in', 'archivo_aspirante_uuid', $archivo_aspirantesincluidos])
                                    ->all();
                            foreach ($archivo_aspirantesparaborrar as $archivo_aspiranteparaborrar) {
                                $archivo_aspiranteparaborrar->delete();
                            }
                            foreach (Yii::$app->request->post()['AspiranteCargo']['archivo_aspirantes'] as $key => $value) {
                                $archivo_aspiranteexistente = ArchivoAspiranteCargo::find()
                                        ->where(['aspirante_cargo_uuid' => $model->uuid])
                                        ->andWhere(['archivo_aspirante_uuid' => $value])
                                        ->one();
                                if (is_null($archivo_aspiranteexistente)) {
                                    $archivo_aspirante = ArchivoAspirante::findOne($value);
                                    $sp = new ArchivoAspiranteCargo();
                                    $sp->uuid = SeleccionHelper::uuid();
                                    $sp->aspirante_cargo_uuid = $model->uuid;
                                    $sp->archivo_aspirante_uuid = $value;
                                    $sp->comentarios_aspirante = $archivo_aspirante->comentarios_aspirante;
                                    $sp->tenido_en_cuenta = 0;
                                    $sp->save();
                                }
                            }
                            return $this->redirect(['view', 'id' => $model->cargo->proceso_id]);
                        } else {
                            Yii::$app->session->setFlash('error', 'Ha occurrido un error al guardar. ' . print_r($model->errors));
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Ha seleccionado una opción que no corresponde al cargo escogido.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'El cargo al que intenta aplicar no es del proceso solicitado.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Está tratando de aplicar a un proceso que no está activo.');
            }
        }
        $archivo_aspirantes = ArchivoAspirante::find()
                ->innerJoin('archivo_aspirante_cargo', 'archivo_aspirante.uuid=archivo_aspirante_cargo.archivo_aspirante_uuid')
                ->where(['archivo_aspirante_cargo.aspirante_cargo_uuid' => $uuid])
                ->all()
        ;
        foreach ($archivo_aspirantes as $archivo_aspirante) {
            $model->archivo_aspirantes_seleccionados = $model->archivo_aspirantes_seleccionados . $archivo_aspirante->uuid . ',';
        }
        $model->numero_archivo_aspirantes = count($archivo_aspirantes);
        $searchModelCargo = new CargoSearch();
        $dataProviderCargo = $searchModelCargo->search([]);
        $dataProviderCargo->query->andWhere(['proceso_id' => $proceso->id]);
        $dataProviderCargo->pagination = false;

        return $this->render('update', [
                    'searchModelCargo' => $searchModelCargo,
                    'dataProviderCargo' => $dataProviderCargo,
                    'model' => $model,
                    'proceso' => $proceso,
        ]);
    }

    /**
     * Finds the AspiranteCargo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AspiranteCargo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AspiranteCargo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
