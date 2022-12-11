<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use common\helpers\Dropdowns;
use common\components\PasswordTextBox;

/* @var $this yii\web\View */
/* @var $model frontend\models\Aspirante */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="aspirante-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'aspirante-form',
                'options' => ['autocomplete' => 'off'],
    ]);
    ?>
    <div class="form-row">
        <div class="col-lg">
            <?= $form->field($model, 'nombres', ['addon' => ['prepend' => ['content' => '<i class="fa fa-user"></i>']]])->textInput(['maxlength' => true, 'disabled' => 'disabled', 'readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg">
            <?= $form->field($model, 'apellidos', ['addon' => ['prepend' => ['content' => '<i class="fa fa-user"></i>']]])->textInput(['maxlength' => true, 'disabled' => 'disabled', 'readonly' => 'readonly']) ?>
        </div>
        <div class="col-lg">
            <?= $form->field($model, 'correo_electronico', ['addon' => ['prepend' => ['content' => '<i class="bi bi-envelope-at"></i>']]])->textInput(['maxlength' => true, 'disabled' => 'disabled', 'readonly' => 'readonly']) ?>
        </div>
    </div>
    <div class="form-row">
        <div class="col-lg">
            <?php
            echo $form->field($model, 'fecha_nacimiento', ['addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']]])->textInput(['type' => 'date', 'disabled' => 'disabled', 'readonly' => 'readonly']);
            ?>
        </div>
        <div class="col-lg">
            <?=
            $form->field($model, 'tipo_identificacion_id', ['addon' => ['prepend' => ['content' => '<i class="bi bi-person-badge-fill"></i>']]])->textInput(['disabled' => 'disabled', 'readonly' => 'readonly', 'value' => $model->tipoIdentificacion->nombre]);
            ?>
        </div>
        <div class="col-lg">
            <?= $form->field($model, 'identificacion', ['addon' => ['prepend' => ['content' => '<i class="icon-contact-businesscard"></i>']]])->textInput(['disabled' => 'disabled', 'readonly' => 'readonly']) ?>
        </div>
    </div>
    <div class="form-row">
        <div class="col-lg-4">
            <?php
            echo $form->field($model, 'celular', ['addon' => ['prepend' => ['content' => '<i class="fa fa-phone"></i>']]])->textInput(['disabled' => 'disabled', 'readonly' => 'readonly']);
            ?>
        </div>
        <div class="col-lg-4">
            <?php
            echo $form->field($model, 'created_at', ['addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']]])->textInput(['type' => 'date', 'disabled' => 'disabled', 'readonly' => 'readonly', 'value' => (new DateTime($model->created_at))->format('Y-m-d')]);
            ?>
        </div>
    </div>
    <div class="form-row">
        <div class="col-lg">
            <?=
            $form->field($model, 'curpassword', ['enableAjaxValidation' => true, 'addon' => ['prepend' => ['content' => '<i class="fa fa-key"></i>']]])->widget(PasswordTextBox::class, [
                'options' => [
                    'maxlength' => true, 'placeholder' => 'Sólo si desea cambiar la contraseña', 'autofocus' => true,
                ],
            ]);
            ?>
        </div>
        <div class="col-lg">
            <?=
            $form->field($model, 'newpassword', ['enableAjaxValidation' => true, 'addon' => ['prepend' => ['content' => '<i class="fa fa-key"></i>']]])->widget(PasswordTextBox::class, [
                'options' => [
                    'maxlength' => true, 'placeholder' => 'Sólo si desea cambiar la contraseña',
                ],
            ]);
            ?>
        </div>
        <div class="col-lg">
            <?=
            $form->field($model, 'password_repeat', ['addon' => ['prepend' => ['content' => '<i class="fa fa-key"></i>']]])->widget(PasswordTextBox::class, [
                'options' => [
                    'maxlength' => true, 'placeholder' => 'Sólo si desea cambiar la contraseña',
                ],
            ]);
            ?>
        </div>
    </div>

    <?php
// echo $form->field($model, 'estado_id')->dropDownList(Dropdowns::estadosaspirantedropdown(), []);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
        &nbsp;
        <?= Html::a('Cancelar', Url::to(['index']), ['type' => 'button', 'class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
