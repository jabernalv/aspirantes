<?php

namespace frontend\controllers;

use Yii;
use common\models\Proceso;
use common\models\search\ProcesoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * ProcesoController implements the CRUD actions for Proceso model.
 */
class ProcesoController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Proceso models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProcesoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Proceso model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $ajax = false) {
        $proceso = Proceso::find()->where(['id' => $id, 'activo' => 1])->one();
        if (!is_null($proceso)) {
            if ($ajax) {
                return $this->renderAjax('viewajax', [
                            'model' => $this->findModel($id),
                ]);
            } else {
                return $this->render('view', [
                            'model' => $this->findModel($id),
                ]);
            }
        } else {
            $this->redirect(['/aspirante']);
        }
    }

    /**
     * Finds the Proceso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proceso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Proceso::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
