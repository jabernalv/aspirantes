<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Volver a enviar el correo de verificación';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-resend-verification-email">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Por favor ingrese la dirección de correo con la cual se registró. Le será enviado un correo para verificarla.</p>
    <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form']); ?>
    <div class="row">
        <div class="col-lg-6">

            <?= $form->field($model, 'correo_electronico')->textInput(['autofocus' => true]) ?>
        </div>
        <div class="col-lg-6">
            <div class="captcha_wrapper">
                <div class="g-recaptcha" data-sitekey="6LeUyMcUAAAAABdPdCjJzIacl2-hI7NaR78UJzjm"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'submit-button', 'id' => 'submit-button']) ?>
                &nbsp;
                <?= Html::resetInput('Borrar', ['class' => 'btn btn-warning', 'name' => 'reset-button']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
