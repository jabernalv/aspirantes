<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\LoginForm */

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;
use common\components\PasswordTextBox;

$this->title = 'Ingreso';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Por favor rellene los siguientes campos para ingresar:</p>
    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'correo_electronico', ['addon' => ['prepend' => ['content' => '<i class="fa fa-envelope"></i>']]])->textInput(['autofocus' => true, 'placeholder' => 'Ingrese el correo electrónico registrado.']) ?>
            <?=
            $form->field($model, 'password', ['addon' => ['prepend' => ['content' => '<i class="fa fa-key"></i>']]])->widget(PasswordTextBox::class, [
                'options' => [
                    'placeholder' => 'Ingrese su contraseña ...',
                ],
            ]);
            ?>
            <?php // echo $form->field($model, 'rememberMe')->checkbox(); ?>
            <div class="form-group">
                <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <div style="color:#999;margin:1em 0">
                Si usted ha olvidado su contraseña puede <?= Html::a('recuperarla', ['site/request-password-reset']) ?>.
                <br>
                ¿No ha recibido correo de verificación? <?= Html::a('Reenviarlo', ['site/resend-verification-email']) ?>
            </div>
        </div>
    </div>
</div>
