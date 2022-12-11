<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Recuperar contraseña';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Por favor ingrese la nueva contraseña:</p>
    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'autofocus' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true,]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
