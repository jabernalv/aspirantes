<?php

namespace frontend\controllers;

use Yii;
use common\models\Aspirante;
use common\models\search\AspiranteSearch;
use common\models\search\ArchivoAspiranteSearch;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AspiranteController implements the CRUD actions for Aspirante model.
 */
class AspiranteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'update', 'foto'],
                'rules' => [
                    [
                        'actions' => ['index', 'update', 'foto'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Aspirante models.
     * @return mixed
     */
    public function actionIndex() {
        $model = $this->findModel(Yii::$app->user->identity->uuid);
        $searchModel = new ArchivoAspiranteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Aspirante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $uuid
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate() {
        $model = $this->findModel(Yii::$app->user->identity->uuid);
        $email = $model->correo_electronico;
        $uuid = $model->uuid;
        $modelform = new Aspirante();
        if (\Yii::$app->request->isAjax && $modelform->load(Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return \kartik\form\ActiveForm::validate($modelform);
        }

        if ($modelform->load(Yii::$app->request->post())) {
            if ($model->validatePassword($modelform->curpassword)) {
                if ($modelform->newpassword != "" && $modelform->newpassword == $modelform->password_repeat) {
                    $passwordhash = $model->password_hash;
                    $model->setPassword($modelform->newpassword);
                    if ($model->save()) {
                        $passhistoria = new \common\models\AspirantePassHistoria();
                        $passhistoria->uuid = \common\helpers\SeleccionHelper::uuid();
                        $passhistoria->aspirante_uuid = Yii::$app->user->identity->uuid;
                        $passhistoria->password_hash = $passwordhash;
                        $passhistoria->save();
                        Yii::$app->user->logout(true);
                        Yii::$app->session->setFlash('success', 'La contraseña se ha cambiado de manera exitosa. Ingrese al sistema con la nueva contraseña.');
                        return $this->goHome();
                    } else {
                        Yii::$app->session->setFlash('error', 'Ha ocurrido un error al guardar. ' . print_r($model->errors, true));
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Las dos contraseñas deben ser iguales.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Las contraseña actual es incorrecta.');
            }
        }
        $model->scenario = 'changepassword';

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Descifra y muestra el pdf que se ha cifrado previamente
     * 
     * @param string $uuid
     * @return mixed
     */
    public function actionFoto() {
        $model = Aspirante::findOne(Yii::$app->user->identity->uuid);
        if (!(is_null($model))) {
            $path = Yii::$app->basePath . DIRECTORY_SEPARATOR . 'web' . $model->urlfoto;
            $fileContent = file_get_contents($path);
            $filename = $model->identificacion . '.png';
            return Yii::$app->response->sendContentAsFile(
                            $fileContent,
                            $filename,
                            ['inline' => true, 'mimeType' => 'image/png']
            );
        } else {
            $this->redirect(['/aspirante']);
        }
    }

    public static function deleteAspirante($uuid) {
        $model = Aspirante::findOne(['uuid' => $uuid, 'status' => Aspirante::STATUS_INACTIVE]);
        if (!is_null($model)) {
            $model->correo_electronico = $model->correo_electronico . uniqid();
            $model->status = Aspirante::STATUS_DELETED;
            $model->identificacion = $model->identificacion . uniqid();
            $model->celular = $model->celular . uniqid();
            $model->verification_token = null;
            $model->delete_token = null;
            $model->auth_key = "";
            $model->save(false);
            $path = Yii::$app->basePath .
                    DIRECTORY_SEPARATOR .
                    'web' .
                    $model->urlfoto;
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    /**
     * Finds the Aspirante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $uuid
     * @return Aspirante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($uuid) {
        if (($model = Aspirante::findOne($uuid)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
