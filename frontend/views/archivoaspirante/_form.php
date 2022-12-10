<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;
use common\helpers\Dropdowns;
use common\helpers\SeleccionHelper;

/* @var $this yii\web\View */
/* @var $model common\models\ArchivoAspirante */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="archivo_aspirante-form">

    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data',
                    'id' => 'archivo_aspirante-form',
                    'action' => Url::to(['/archivoaspirante/create']),
                ]
    ]);
    ?>
    <div class="row">
        <div class="col-lg-6">
            <?php
            $pluginOptions = [
                'language' => 'es',
                'allowedFileExtensions' => ['pdf'],
                'showUpload' => false,
                'showCaption' => false,
                'showRemove' => true,
                //'browseClass' => 'btn btn-primary btn-block',
                //'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' => 'Agregar archivo',
                'overwriteInitial' => true,
                //'showPreview' => false,
                'minFileCount' => 0,
                'maxFileCount' => 1,
                //'uploadExtraData' => ['aspirante_uuis' => $model->UUID],
                'uploadAsync' => false,
                'initialPreview' => [],
                'initialPreviewAsData' => true,
                'initialPreviewConfig' => [],
                'initialPreviewFileType' => 'pdf',
                'maxFileSize' => floor(SeleccionHelper::maximumFileUploadSize() / 1000),
                    //'deleteUrl' => Url::to(['/productfile/delete']),
            ];
            echo $form->field($model, 'archivo')->widget(FileInput::class, [
                'options' => [
                    'id' => 'archivo_aspirante-archivo',
                    'accept' => 'application/pdf',
                    'multiple' => false,
                    'name' => 'kartik_input_archivo_aspirante_archivo',
                ],
                //'resizeImages' => true,
                'pluginOptions' => $pluginOptions,
            ]); /* */
            ?>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    <?=
                    $form->field($model, 'tipo_archivo_aspirante_id')->widget(Select2::class, [
                        'data' => Dropdowns::tiposarchivo_aspirantedropdown(),
                        'options' => [
                            'placeholder' => 'Seleccione ...',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?= $form->field($model, 'comentarios_aspirante')->textarea(['maxlength' => true, 'rows' => 4, 'placeholder' => 'Breve descripción del archivo. No más de 255 caracteres.']) ?>
                </div>
                <div class="col-lg-12" id="conteocaracteres" style="width:100% !important;text-align:right;font-size:small;color:red;">
                    255 caracteres restantes
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success', 'id' => 'submit-archivo_aspirante']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"><hr></div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="error-archivo_aspirante"></div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$js = <<< JS
$("#archivo_aspirante-comentarios_aspirante").keyup(function(e){var rest=$(this).attr('maxlength')-$(this).val().length;$("#conteocaracteres").html(rest+' caracteres restantes');});
$("#submit-archivo_aspirante").on("click", function(event){
  event.preventDefault();
  var form = $("#archivo_aspirante-form");
  var data = form.data("yiiActiveForm");
  var _url = form.attr("action");
  $.each(data.attributes, function() { this.status = 3; });
  form.yiiActiveForm("validate");
  if (!(form.find(".has-error").length)) {
    var _data = new FormData(form[0]);
    $.ajax({
      url: _url,
      type: "post",
      enctype: 'multipart/form-data',
      data: _data,
      processData: false,
      contentType: false,
      cache: false,
      timeout: 800000,
      success: function (response) {
        if(response.resultado){
          $("#close-main-modal").click();
        }else{
          $("#error-archivo_aspirante").html("<div class='alert-danger alert alert-dismissible' role='alert'>" + response.error + "</div>");
        }
      }
    });
    return false;
  }
});
JS;
$this->registerJs($js);
