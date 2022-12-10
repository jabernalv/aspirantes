<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;

$this->title = 'Contactenos';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/css/contact-form.css?' . time());
//$this->registerJsFile('/js/contact-form.js');
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-12">
            Si tiene alguna inquietud por favor diligencie el siguiente formulario para contactarnos. Gracias.
        </div>
    </div>
    <hr>
    <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['class' => 'popup-form'],]); ?>
    <div class="row">
        <div class="col-lg-6">
            <?=
                    $form->field($model, 'name', ['addon' => ['prepend' => ['content' => '<i class="fa fa-user"></i>']]])
                    ->textInput([
                        'autofocus' => true,
                        'placeholder' => 'Nombre completo',
                        'class' => 'form-control triminput nombres',
                        'value' => ((Yii::$app->user->isGuest) ? '' : Yii::$app->user->identity->nombres . ' ' . Yii::$app->user->identity->apellidos),
                        'readonly' => !(Yii::$app->user->isGuest),
                    ])
                    ->label(false)
            ?>
        </div>
        <div class="col-lg-6">
            <?=
                    $form->field($model, 'email', ['addon' => ['prepend' => ['content' => '<i class="fa fa-envelope"></i>']]])
                    ->textInput([
                        'placeholder' => 'Correo electrónico',
                        'class' => 'form-control triminput correo',
                        'value' => ((Yii::$app->user->isGuest) ? '' : Yii::$app->user->identity->correo_electronico),
                        'readonly' => !(Yii::$app->user->isGuest),
                    ])
                    ->label(false)
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?=
                    $form->field($model, 'subject', ['addon' => ['prepend' => ['content' => '<i class="fa fa-edit"></i>']]])
                    ->textInput(['placeholder' => 'Asunto del mensaje', 'class' => 'form-control triminput'])
                    ->label(false)
            ?>
        </div>
        <div class="col-lg-6">
            <?=
                    $form->field($model, 'phone', ['addon' => ['prepend' => ['content' => '<i class="fa fa-phone"></i>']]])
                    ->textInput([
                        'maxlength' => '13',
                        'placeholder' => 'Teléfono de contacto',
                        'type' => 'number',
                        'step' => '1',
                        'value' => ((Yii::$app->user->isGuest) ? '' : Yii::$app->user->identity->celular),
                        'readonly' => !(Yii::$app->user->isGuest),
                    ])
                    ->label(false)
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?=
                    $form->field($model, 'body', ['addon' => ['prepend' => ['content' => '<i class="fa fa-file-alt"></i>']]])
                    ->textarea(['rows' => 6, 'placeholder' => 'Mensaje'])
                    ->label(false)
            ?>
        </div>
    </div>
    <div class="row">
        <?php if (Yii::$app->user->isGuest) : ?>
            <div class="captcha_wrapper col-lg-6">
                <div class="g-recaptcha" data-sitekey="6LeUyMcUAAAAABdPdCjJzIacl2-hI7NaR78UJzjm" data-callback="enableSubmit" data-expired-callback="disableSubmit"></div>
            </div>
        <?php endif; ?>
        <div class="form-group col-lg-6">
            <?= Html::submitButton('<i class="fa fa-envelope"></i> Enviar', ['class' => 'btn btn-custom', 'name' => 'contact-button', 'id' => 'contact-button']) ?>
            &nbsp;
            <?= Html::button('<i class="fa fa-eraser"></i> Borrar', ['class' => 'btn btn-warning', 'name' => 'reset-button', 'type' => 'reset', 'id' => 'reset-button', 'onclick' => 'return confirm("¿Seguro que desea borrar el formulario?");']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$guest = (Yii::$app->user->isGuest) ? 0 : 1;
$js = <<< JS
$(':input[type="submit"]').prop('disabled', !$guest);
$(() =>{function _enable(){ $(':input[type="submit"]').prop('disabled',!1);}function _disable(){ $(':input[type="submit"]').prop('disabled',!0);}enableSubmit=_enable;disableSubmit=_disable;});
$(".triminput").on("focusout",function(e){ $("#message-signup").html("");$(this).val($.trim($(this).val()));});
$(".nombres").on("keyup", function(e){var pos=e.target.selectionStart; $(this).val($(this).val().toUpperCase());setCaretPosition(this,pos);});
$(".correo").on("keyup", function(e){var pos=e.target.selectionStart; $(this).val($(this).val().toLowerCase());setCaretPosition(this,pos);});
$(':input[type="number"]').on("keypress",function(e){ if(e.keyCode===101||e.keyCode===44||e.keyCode===45||e.keyCode===46){e.preventDefault();return;}if($(this).val().length>=$(this).attr('maxlength')){e.preventDefault();}});
JS;
$this->registerJs($js);
