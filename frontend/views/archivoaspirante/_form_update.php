<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\helpers\Dropdowns;

/* @var $this yii\web\View */
/* @var $model common\models\ArchivoAspirante */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="archivo_aspirante-form">
    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'id' => 'archivo_aspirante-form',
                    'action' => Url::to(['/archivoaspirante/update']),
                ]
    ]);
    ?>
    <div class="row">
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
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    <?= $form->field($model, 'comentarios_aspirante')->textarea(['maxlength' => true, 'rows' => 4, 'placeholder' => 'Breve descripción del archivo. No más de 255 caracteres.']) ?>
                </div>
                <div class="col-lg-12" id="conteocaracteres" style="width:100% !important;text-align:right;font-size:small;color:red;">
                    <?= (255 - strlen($model->comentarios_aspirante)); ?> caracteres restantes
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="row">
        <div class="col-lg-12">
            <?=
            \yii2assets\pdfjs\PdfJs::widget([
                'width' => '100%',
                'url' => Url::toRoute(['/archivoaspirante/pdf', 'uuid' => $model->uuid]),
                'buttons' => [
                    'presentationMode' => true,
                    'openFile' => false,
                    'print' => false,
                    'download' => false,
                    'viewBookmark' => false,
                    'secondaryToolbarToggle' => false,
                ]
            ]);
            ?>
        </div>
    </div>
</div>
<?php
$js = <<< JS
$("#archivo_aspirante-comentarios_aspirante").keyup(function(e){var rest=$(this).attr('maxlength')-$(this).val().length;$("#conteocaracteres").html(rest+' caracteres restantes');});
JS;
$this->registerJs($js);
