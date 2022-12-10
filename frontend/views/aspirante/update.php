<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Aspirante */

$this->title = Yii::t('app', '{name}', [
    'name' => $model->nombres . ' ' . $model->apellidos,
]);
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aspirantes'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->uuid, 'url' => ['view', 'uuid' => $model->uuid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizando');
?>
<div class="aspirante-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
