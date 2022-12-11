<?php

use yii\bootstrap5\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Entidad */

$this->title = Yii::t('app', 'Create Entidad');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entidads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entidad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
