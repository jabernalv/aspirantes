<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\AspiranteCargo */

$this->title = 'Registro de aplicación a cargo';
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aspirante Cargos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="aspirante-cargo-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($model->cargo->proceso->fecha_fin_aplicacion >= date("Y-m-d")) : ?>
        <p>
            <?= Html::a(Yii::t('app', 'Modificar'), ['update', 'uuid' => $model->uuid], ['class' => 'btn btn-primary']) ?>
        </p>
    <?php endif; ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'uuid',
            [
                'attribute' => 'aspirante_uuid',
                'value' => $model->aspirante->nombres . ' ' . $model->aspirante->apellidos,
            ],
            [
                'attribute' => 'entidad',
                'value' => $model->cargo->proceso->entidad->nombre,
            ],
            [
                'attribute' => 'proceso',
                'value' => $model->cargo->proceso->nombre,
            ],
            [
                'attribute' => 'cargo_id',
                'value' => $model->cargo->nombre,
            ],
            [
                'attribute' => 'opcion_cargo_id',
                'value' => $model->opcionCargo->opcion,
            ],
            //'estado_id',
            'created_at',
        //'modified_at',
        ],
    ]);
    ?>
</div>
<div class="archivo_aspirante-index"></div>
<?php
$urlarchivo_aspirantes = Url::to(['/archivoaspirante/index', 'destino' => 'aspirantecargo', 'aspirante_cargo_uuid' => $model->uuid]);
$js = <<< JS
var urlarchivo_aspirantes='$urlarchivo_aspirantes';
$(document).ready(function(e){
  $(".archivo_aspirante-index").load(urlarchivo_aspirantes);
});
$('#modaldialog').on('hidden.bs.modal', function (e) {
  $(".archivo_aspirante-index").load(urlarchivo_aspirantes);
});
JS;
$this->registerJs($js);
