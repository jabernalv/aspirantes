<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Aspirante */
/* @var $searchModel common\models\search\ArchivoAspiranteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->nombres . ' ' . $model->apellidos;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aspirantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="aspirante-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Modificar contraseña'), ['update'], ['class' => 'btn btn-primary']) ?>
    </p>
    <div class="row">
        <div class="col-lg-8">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'nombre_completo',
                    'correo_electronico',
                    'fecha_nacimiento',
                    'identificacion_completo',
                    'celular',
                    'created_at',
                //'updated_at',
                ],
            ])
            ?>
        </div>
        <div class="col-lg-4">
            <div class="container">
                <img src="<?= Url::to(['/aspirante/foto']) ?>" class="img-fluid" style="width: 100%;" alt="Fotografía <?= $this->title ?>" />
                <div class="content">
                    <h1>Fotografía</h1>
                    <p>No se puede cambiar</p>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="archivo_aspirante-index"></div>
<?php
$urlarchivo_aspirantes = Url::to(['/archivoaspirante/index', 'destino' => 'aspirante']);
$js = <<< JS
var urlarchivo_aspirantes='$urlarchivo_aspirantes';
$(document).ready(function(){
  $(".archivo_aspirante-index").load(urlarchivo_aspirantes);
});
$('#modaldialog').on('hidden.bs.modal', function (e) {
  $(".archivo_aspirante-index").load(urlarchivo_aspirantes);
});
JS;
$this->registerJs($js);

