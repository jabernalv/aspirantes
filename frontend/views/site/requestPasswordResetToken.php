<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Recuperación de contraseña';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor ingrese su dirección de correo electrónico. Un enlace para recuperar la contraseña le será enviado.</p>
    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
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
        <div class="col-lg-6">
            <div class="form-group">
                <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'submit-button', 'id' => 'submit-button']) ?>
                &nbsp;
                <?= Html::resetInput('Borrar', ['class' => 'btn btn-warning', 'name' => 'reset-button']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>