<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ArchivoProcesoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Archivo Procesos';
?>
<div class="archivo-proceso-index">
    <?=
    GridView::widget([
        'panelBeforeTemplate' => '',
        'panel' => [
            'heading' => "Archivos del proceso",
            'type' => GridView::TYPE_INFO,
            'footer' => false,
        ],
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            //'id',
            //'proceso_id',
            'descripcion',
            //'ruta_web',
            //'md5',
            //'created_at',
            //'modified_at',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::button('<svg class="svg-inline--fa fa-eye fa-w-18" aria-hidden="true" data-prefix="fas" data-icon="eye" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M569.354 231.631C512.969 135.949 407.81 72 288 72 168.14 72 63.004 135.994 6.646 231.631a47.999 47.999 0 0 0 0 48.739C63.031 376.051 168.19 440 288 440c119.86 0 224.996-63.994 281.354-159.631a47.997 47.997 0 0 0 0-48.738zM288 392c-75.162 0-136-60.827-136-136 0-75.162 60.826-136 136-136 75.162 0 136 60.826 136 136 0 75.162-60.826 136-136 136zm104-136c0 57.438-46.562 104-104 104s-104-46.562-104-104c0-17.708 4.431-34.379 12.236-48.973l-.001.032c0 23.651 19.173 42.823 42.824 42.823s42.824-19.173 42.824-42.823c0-23.651-19.173-42.824-42.824-42.824l-.032.001C253.621 156.431 270.292 152 288 152c57.438 0 104 46.562 104 104z"></path></svg><!-- <span class="fas fa-eye" aria-hidden="true"></span> -->',
                                        [
                                            'value' => $url,
                                            'title' => Yii::t('app', 'Documento de proceso'),
                                            'class' => 'showModalButton botongrid',
                                            'data-pjax' => '0',
                                        ]
                        );
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = Url::toRoute(['/archivoproceso/view', 'id' => $model->id]);
                        return $url;
                    }
                }
            ],
        ],
        'summary' => '',
    ]);
    ?>


</div>
