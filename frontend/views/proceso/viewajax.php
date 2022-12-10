<?php

use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Proceso */
\yii\web\YiiAsset::register($this);
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'entidad_id',
            'value' => $model->entidad->nombre,
        ],
        'nombre',
    ],
]);
?>
<div class="archivo-proceso-index"></div>
<?php
$urlarchivo_proceso = Url::to(['/archivoproceso/index', 'id' => $model->id]);
$js = <<< JS
var urlarchivo_proceso='$urlarchivo_proceso';
$(document).ready(function(){
  $(".archivo-proceso-index").load(urlarchivo_proceso);
});
JS;
$this->registerJs($js);


