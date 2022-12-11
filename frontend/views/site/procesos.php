<?php
/* @var $this yii\web\View */

use yii\bootstrap5\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

$this->title = 'Acerca de...';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Este es el sitio para registro de aspirantes a procesos de selección, en el momento se tienen los siguientes procesos en realización:</p>

    <?php
    $columns = [
        ['class' => 'kartik\grid\SerialColumn'],
        //'id',
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'entidad_id',
            'value' => 'entidad.nombre',
            'format' => 'raw',
            'enableSorting' => true,
        ],
        'nombre',
            //'activo',
    ];
    if (!(Yii::$app->user->isGuest)) {
        $columns[] = [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{view}&nbsp;{update}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="fas fa-eye" aria-hidden="true"></span>', $url, [
                                'title' => Yii::t('app', 'lead-view'),
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a('<span class="fas fa-pencil-alt" aria-hidden="true"></span>', $url, [
                                'title' => Yii::t('app', 'lead-update'),
                    ]);
                }
            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    $url = Url::toRoute(['/aspirantecargo/view', 'id' => $model->id]);
                    return $url;
                }
                if ($action === 'update') {
                    
                    $url = Url::toRoute(['/aspirantecargo/create', 'id' => $model->id]);
                    return $url;
                }
            }
        ];
    }
    echo GridView::widget([
        'panelBeforeTemplate' => '',
        'panel' => [
            'heading' => "Procesos",
            'type' => GridView::TYPE_INFO,
            'footer' => false,
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]);
    ?>
</div>
