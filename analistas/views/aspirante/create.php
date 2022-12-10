<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Aspirante */

$this->title = Yii::t('app', 'Create Aspirante');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aspirantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aspirante-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
