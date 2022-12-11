<?php

use yii\bootstrap5\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AspiranteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Aspirantes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aspirante-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Aspirante'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            //'uuid',
            'nombres',
            'apellidos',
            'correo_electronico',
            //'password_hash',
            //'fecha_nacimiento',
            //'tipo_identificacion_id',
            //'identificacion',
            //'status',
            //'verification_token',
            //'password_reset_token',
            //'auth_key',
            //'ip_creacion',
            //'created_at',
            //'updated_at',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
