<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\RadioColumn;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OpcionCargoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = Yii::t('app', 'Opcion Cargos');
//$this->params['breadcrumbs'][] = $this->title;
?>
<?=

GridView::widget([
  'dataProvider' => $dataProvider,
  //'filterModel' => $searchModel,
  'id' => 'opciones-grid',
  'columns' => [
    //['class' => 'kartik\grid\SerialColumn'],
    [
      'class' => RadioColumn::class,
      //'attribute' => 'selected',
      'header' => '',
      'name' => 'radio-opcion',
    ],
    //'id',
    //'cargo_id',
    'opcion',
  //'requiere_titulo',
  //'anios_experiencia_profesional',
  //'anios_experiencia_relacionada',
  //'created_at',
  //'modified_at',
  //['class' => 'kartik\grid\ActionColumn'],
  ],
  'summary' => '',
]);
?>
<?php

$js = <<< JS
var opcionesgrid = $('#opciones-grid');
opcionesgrid.on('grid.radiochecked', function(ev, key, val){
  $("#aspirantecargo-opcion_cargo_id").val( key );
});
JS;
$this->registerJs($js);
