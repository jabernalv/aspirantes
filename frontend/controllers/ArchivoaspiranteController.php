<?php

namespace frontend\controllers;

use Yii;
use common\models\ArchivoAspirante;
use common\models\search\ArchivoAspiranteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\SeleccionHelper;
use yii\filters\AccessControl;

/**
 * ArchivoaspiranteController implements the CRUD actions for ArchivoAspirante model.
 */
class ArchivoaspiranteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'pdf', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'pdf', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ArchivoAspirante models.
     * @return mixed
     */
    public function actionIndex($destino = '', $aspirante_cargo_uuid = null, $seleccionados = null) {
        $searchModel = new ArchivoAspiranteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['archivo_aspirante.aspirante_uuid' => Yii::$app->user->identity->uuid]);
        if (!is_null($aspirante_cargo_uuid)) {
            $dataProvider->query->innerJoin('archivo_aspirante_cargo', 'archivo_aspirante.uuid=archivo_aspirante_cargo.archivo_aspirante_uuid');
            $dataProvider->query->andWhere(['aspirante_cargo_uuid' => $aspirante_cargo_uuid]);
        }
        $dataProvider->query->orderBy('archivo_aspirante.created_at');
        $view = 'indexpara' . $destino;
        return $this->renderAjax($view, [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'identificacion' => ArchivoAspirante::findOne(['aspirante_uuid' => Yii::$app->user->identity->uuid, 'tipo_archivo_aspirante_id' => 1]),
                    'seleccionados' => (is_null($seleccionados)) ? "" : $seleccionados,
        ]);
    }

    /**
     * Displays a single ArchivoAspirante model.
     * @param string $uuid
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($uuid) {
        $model = ArchivoAspirante::findOne($uuid);
        if (!(is_null($model)) && $model->aspirante->uuid == Yii::$app->user->identity->uuid) {
            return $this->renderAjax('view', [
                        'model' => $model,
            ]);
        } else {
            return $this->redirect('/aspirante');
        }
    }

    /**
     * Descifra y muestra el pdf que se ha cifrado previamente
     * 
     * @param string $uuid
     * @return mixed
     */
    public function actionPdf($uuid) {
        $model = ArchivoAspirante::findOne($uuid);
        if (!(is_null($model)) && $model->aspirante->uuid == Yii::$app->user->identity->uuid) {
            $path = $model->ruta_web;
            $temp = tempnam(sys_get_temp_dir(), 'arc');
            SeleccionHelper::decryptFile(
                    Yii::$app->params['uploadPath'] = Yii::$app->basePath . DIRECTORY_SEPARATOR . 'web' . $path,
                    Yii::$app->params['cipherkey'],
                    $temp);
            $fileContent = file_get_contents($temp);
            unlink($temp);
            $filename = $model->comentarios_aspirante . '.pdf';
            return Yii::$app->response->sendContentAsFile(
                            $fileContent,
                            $filename,
                            ['inline' => true, 'mimeType' => 'application/pdf']
            );
        } else {
            $this->redirect(['/aspirante']);
        }
    }

    /**
     * Función interna invocada para verificar un archivo_aspirantes
     * @param string $archivotemporal
     * @param \common\models\ArchivoAspirante $model
     * @return array
     */
    private function verificaArchivoAspirante($archivotemporal, $model, $identificacion) {
        /* Se verifica que el archivo que se cargó es de tipo pdf */
        if (mime_content_type($archivotemporal) == 'application/pdf') { // Si el archivo es de tipo pdf
            /* Se verifica que el archivo que se está intentando cargar no haya sido cargado previamente */
            $model->md5 = md5_file($archivotemporal);
            $model->aspirante_uuid = Yii::$app->user->identity->uuid;
            /* Para ello se utiliza el hash md5 del archivo */
            $archivo_aspirante = ArchivoAspirante::find()->where(['aspirante_uuid' => $model->aspirante_uuid, 'md5' => $model->md5])->one();
            if (is_null($archivo_aspirante)) { // Si el archivo no se ha cargado previamente
                return SeleccionHelper::creaArchivoAspirante($archivotemporal, $identificacion, $identificacion . '_' . Yii::$app->security->generateRandomString(), $model);
            } else {
                return ['resultado' => false, 'error' => 'El archivo que intenta cargar ya está en el sistema.'];
            }
        } else {
            return ['resultado' => false, 'error' => 'El archivo que se intentó cargar no tiene el formato .pdf esperado o está dañado.'];
        }
    }

    /**
     * Función interna invocada para cargar un archivo_aspirante
     * 
     * @param array $files_input
     * @param \common\models\ArchivoAspirante $model
     * @return array
     */
    private function cargaArchivoAspirante($files_input, $model, $identificacion) {
        if (!empty($files_input)) {
            /* Identificamos la ruta donde se cargó el archivo */
            $archivotemporal = $files_input['tmp_name'];
            /* Se verifica que el archivo no esté cifrado */
            $handle = fopen($archivotemporal, "r");
            $contents = fread($handle, filesize($archivotemporal));
            fclose($handle);
            if (!(stristr($contents, "/Encrypt"))) { // Si el archivo no está cifrado
                return $this->verificaArchivoAspirante($archivotemporal, $model, $identificacion);
            } else {

                return ['resultado' => false, 'error' => 'El pdf cargado tiene contraseña, no se permiten archivos con contraseña.'];
            }
        } else {
            return ['resultado' => false, 'error' => 'No se ha cargado ningún archivo.'];
        }
    }

    /**
     * Creates a new ArchivoAspirante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        if (Yii::$app->request->isAjax) {
            $model = new ArchivoAspirante();
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $input = 'kartik_input_archivo_aspirante_archivo'; // the input name for the fileinput plugin
                return $this->cargaArchivoAspirante($_FILES[$input], $model, Yii::$app->user->identity->identificacion);
            } else {
                return $this->renderAjax('_form', [
                            'model' => $model,
                ]);
            }
        } else {
            $this->redirect(['/aspirante']);
        }
    }

    /**
     * Updates an existing ArchivoAspirante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($uuid) {
        $model = ArchivoAspirante::findOne($uuid);
        if (!(is_null($model)) && $model->tipo_archivo_aspirante_id != 1 && $model->aspirante->uuid == Yii::$app->user->identity->uuid) {
            $modelform = new ArchivoAspirante();
            if ($modelform->load(Yii::$app->request->post())) {
                $model->tipo_archivo_aspirante_id = $modelform->tipo_archivo_aspirante_id;
                $model->comentarios_aspirante = $modelform->comentarios_aspirante;
                if ($model->save()) {
                    return $this->redirect('/aspirante');
                }
            }
            return $this->renderAjax('_form_update', [
                        'model' => $model,
            ]);
        } else {
            return $this->redirect('/aspirante');
        }
    }

    /**
     * Deletes an existing ArchivoAspirante model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($uuid) {
        $model = $this->findModel($uuid);
        if ($model->tipo_archivo_aspirante_id != 1 && $model->aspirante_uuid == \Yii::$app->user->identity->uuid && count($model->cargos) == 0) {
            if ($model->delete()) {
                $path = Yii::$app->basePath .
                        DIRECTORY_SEPARATOR .
                        'web' .
                        $model->ruta_web;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        return $this->redirect(['/aspirante/index']);
    }

    public static function deleteArchivo($uuid) {
        $model = static::findModel($uuid);
        if ($model->aspirante->status == \common\models\Aspirante::STATUS_DELETED && $model->delete()) {
            $path = Yii::$app->basePath .
                    DIRECTORY_SEPARATOR .
                    'web' .
                    $model->ruta_web;
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    /**
     * Finds the ArchivoAspirante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ArchivoAspirante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($uuid) {
        if (($model = ArchivoAspirante::findOne($uuid)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
