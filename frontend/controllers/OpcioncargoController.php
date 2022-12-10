<?php

namespace frontend\controllers;

use Yii;
use common\models\OpcionCargo;
use common\models\search\OpcionCargoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * OpcioncargoController implements the CRUD actions for OpcionCargo model.
 */
class OpcioncargoController extends Controller {

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
            'actions' => ['index'],
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
    ];
  }

  /**
   * Lists all OpcionCargo models.
   * @return mixed
   */
  public function actionIndexajax($id) {
    $searchModel = new OpcionCargoSearch();
    $dataProvider = $searchModel->search([]);
    $dataProvider->pagination = false;
    $dataProvider->query->andWhere(['cargo_id' => $id]);

    return $this->renderajax('indexajax', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
  }

  public function actionOpcionescargo() {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
      $cargo_id = end($_POST['depdrop_parents']);
      $opcionesCargo = OpcionCargo::find()->andWhere(['cargo_id' => $cargo_id])->all();
      $selected = null;
      if ($cargo_id != null && count($opcionesCargo) > 0) {
        $selected = '';
        foreach ($opcionesCargo as $i => $opcionCargo) {
          $out[] = ['id' => $opcionCargo->id, 'name' => $opcionCargo->opcion];
          if ($i == 0) {
            $selected = $opcionCargo->id;
          }
        }
        // Shows how you can preselect a value
        return ['output' => $out, 'selected' => $selected];
      }
    }
    return ['output' => '', 'selected' => ''];
  }

  /**
   * Displays a single OpcionCargo model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id) {
    return $this->render('view', [
        'model' => $this->findModel($id),
    ]);
  }

  /**
   * Finds the OpcionCargo model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return OpcionCargo the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id) {
    if (($model = OpcionCargo::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
  }

}
