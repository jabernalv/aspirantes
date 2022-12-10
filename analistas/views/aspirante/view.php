<?php

use yii\bootstrap4\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Aspirante */

$this->title = $model->uuid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aspirantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="aspirante-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->uuid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->uuid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'uuid',
            'nombres',
            'apellidos',
            'correo_electronico',
            'password_hash',
            'fecha_nacimiento',
            'tipo_identificacion_id',
            'identificacion',
            'status',
            'verification_token',
            'password_reset_token',
            'auth_key',
            'ip_creacion',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
