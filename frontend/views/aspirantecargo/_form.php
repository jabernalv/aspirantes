<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\grid\RadioColumn;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\AspiranteCargo */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $proceso common\models\Proceso */
/* @var $searchModelCargo common\models\search\CargoSearch */
/* @var $dataProviderCargo yii\data\ActiveDataProvider */
?>
<div class="aspirante-cargo-form">
    <?php $form = ActiveForm::begin([
        'options' => [
          'id' => 'aspirante-cargo-form',
        ]
    ]); ?>
    <?php
    echo Html::hiddenInput('requiere_pin', $proceso->requiere_pin, ['id' => 'requiere_pin']);
    echo ($proceso->requiere_pin) ? $form->field($model, 'pin_proceso_uuid')->textInput(['maxlength' => true, 'placeholder' => 'Ingrese el PIN que obtuvo para el registro a este proceso', 'readonly' => !($model->isNewRecord), 'disabled' => !($model->isNewRecord)]) : $form->field($model, 'pin_proceso_uuid')->hiddenInput()->label(false);
    ?>
    <?php
    echo $form->field($model, 'cargo_id')->hiddenInput()->label(false);
    ?>
    <div class="cargo-index">
        <?php Pjax::begin(); ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProviderCargo,
            //'filterModel' => $searchModelCargo,
            'id' => 'cargos-grid',
            'columns' => [
                //['class' => 'kartik\grid\SerialColumn'],
                [
                    'class' => RadioColumn::class,
                    //'attribute' => 'selected',
                    'header' => '',
                    'name' => 'radio-cargo',
                ],
                //'id',
                //'proceso_id',
                'nombre',
            //'created_at',
            //'modified_at',
            //['class' => 'kartik\grid\ActionColumn'],
            ],
            'summary' => '',
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
    <?php
    echo $form->field($model, 'opcion_cargo_id')->hiddenInput()->label(false);
    ?>
    <div class="opciones-index"></div>
    <?php
    echo $form->field($model, 'archivo_aspirantes_seleccionados')->hiddenInput()->label(false);
    echo $form->field($model, 'numero_archivo_aspirantes')->hiddenInput()->label(false);
    ?>
    <div class="archivo_aspirante-index"></div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$urlopciones = Url::to(['/opcioncargo/indexajax', 'id' => '']);
$urlarchivosaspirante = Url::to(['/archivoaspirante/index', 'destino' => 'aplicacion', 'seleccionados' => '']);
$actualizando = ($model->isNewRecord) ? 0 : 1;
if($model->isNewRecord){
    $cargo_id = 0;
    $opcion_cargo_id = 0;
} else {
    $cargo_id = $model->cargo_id;
    $opcion_cargo_id = $model->opcion_cargo_id;
}
$js = <<< JS
var urlopciones='$urlopciones',urlarchivosaspirante='$urlarchivosaspirante',cargosgrid=$('#cargos-grid'),actualizando=$actualizando,cargo_id=$cargo_id,opcion_cargo_id=$opcion_cargo_id;
cargosgrid.on('grid.radiochecked', function(ev, key, val){
  cargaOpciones(key);
});
$(document).ready(function(){
  $(".archivo_aspirante-index").load(urlarchivosaspirante + $("#aspirantecargo-archivo_aspirantes_seleccionados").val());
  $(":radio[name=radio-cargo][value="+cargo_id+"]").attr('checked',true);
  if(actualizando==1){
    cargaOpciones(cargo_id);
  }
});
function cargaOpciones(key){
  $("#aspirantecargo-cargo_id").val( key );
  $("#aspirantecargo-opcion_cargo_id").val( "" );
  $.ajax({
    url: urlopciones + key,
    type: "get",
    cache: false,
    async: true,
    success: function (response) {
      $(".opciones-index").html(response);
    }
  }).done(function(){
    if(actualizando==1){
      $(":radio[name=radio-opcion][value="+opcion_cargo_id+"]").attr('checked',true);
      $("#aspirantecargo-opcion_cargo_id").val(opcion_cargo_id);
      actualizando=0;
    }
  }).fail(function(){}).always(function(){});
}
$('#modaldialog').on('hidden.bs.modal', function (e) {
  $(".archivo_aspirante-index").load(urlarchivosaspirante + $("#aspirantecargo-archivo_aspirantes_seleccionados").val());
});
JS;
$this->registerJs($js);
