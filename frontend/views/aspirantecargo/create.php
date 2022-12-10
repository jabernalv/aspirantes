<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\AspiranteCargo */
/* @var $proceso common\models\Proceso */
/* @var $searchModelCargo common\models\search\CargoSearch */
/* @var $dataProviderCargo yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Registro de aspirante a cargo');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aspirante Cargos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="proceso-view"></div>
<div class="aspirante-cargo-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'proceso' => $proceso,
        'dataProviderCargo' => $dataProviderCargo,
    ])
    ?>
</div>
<?php
$urlproceso = Url::to(['/proceso/view', 'id' => $proceso->id, 'ajax' => true]);
$js = <<< JS
var urlproceso='$urlproceso';
$(document).ready(function(){
  $(".proceso-view").load(urlproceso);
});
JS;
$this->registerJs($js);
