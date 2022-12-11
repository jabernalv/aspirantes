<?php

use yii\bootstrap5\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Aspirante */

$this->title = Yii::t('app', 'Update Aspirante: {name}', [
    'name' => $model->uuid,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aspirantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->uuid, 'url' => ['view', 'id' => $model->uuid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="aspirante-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
