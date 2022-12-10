<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\ArchivoAspiranteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="archivo_aspirante-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'uuid') ?>

    <?= $form->field($model, 'aspirante_uuid') ?>

    <?= $form->field($model, 'tipo_archivo_aspirante_id') ?>

    <?= $form->field($model, 'comentarios_aspirante') ?>

    <?= $form->field($model, 'archivo_nombre_carga') ?>

    <?php // echo $form->field($model, 'ruta_web') ?>

    <?php // echo $form->field($model, 'md5') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'modified_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
