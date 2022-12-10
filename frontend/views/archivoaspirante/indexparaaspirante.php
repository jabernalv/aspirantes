<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ArchivoAspiranteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//$this->params['breadcrumbs'][] = $this->title;
echo GridView::widget([
    'panelBeforeTemplate' => '',
    'panel' => [
        'heading' => "Archivos del aspirante",
        'type' => GridView::TYPE_INFO,
        'footer' => false,
    ],
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        //['class' => 'kartik\grid\SerialColumn'],
        //'uuid',
        //'aspirante_uuid',
        [
            'attribute' => 'tipo_archivo_aspirante_id',
            'value' => function($data) {
                return $data->tipoArchivoAspirante->nombre;
            },
        ],
        'comentarios_aspirante',
        //'archivo_nombre_carga',
        //'ruta_web',
        //'md5',
        //'created_at',
        //'modified_at',
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{view}{update}&nbsp;{delete}',
            'header' => Html::button('+', [
                'value' => Url::to(['/archivoaspirante/create']),
                'title' => 'Nuevo archivo_aspirante',
                'class' => 'showModalButton btn btn-success', 'data-pjax' => '0',
                'id' => 'create-archivo_aspirante-button',
            ]),
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::button('<svg class="svg-inline--fa fa-eye fa-w-18" aria-hidden="true" data-prefix="fas" data-icon="eye" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M569.354 231.631C512.969 135.949 407.81 72 288 72 168.14 72 63.004 135.994 6.646 231.631a47.999 47.999 0 0 0 0 48.739C63.031 376.051 168.19 440 288 440c119.86 0 224.996-63.994 281.354-159.631a47.997 47.997 0 0 0 0-48.738zM288 392c-75.162 0-136-60.827-136-136 0-75.162 60.826-136 136-136 75.162 0 136 60.826 136 136 0 75.162-60.826 136-136 136zm104-136c0 57.438-46.562 104-104 104s-104-46.562-104-104c0-17.708 4.431-34.379 12.236-48.973l-.001.032c0 23.651 19.173 42.823 42.824 42.823s42.824-19.173 42.824-42.823c0-23.651-19.173-42.824-42.824-42.824l-.032.001C253.621 156.431 270.292 152 288 152c57.438 0 104 46.562 104 104z"></path></svg><!-- <span class="fas fa-eye" aria-hidden="true"></span> -->',
                                    [
                                        'value' => $url,
                                        'title' => Yii::t('app', 'Ver'),
                                        'class' => 'showModalButton botongrid',
                                        'data-pjax' => '0',
                                    ]
                    );
                },
                'update' => function ($url, $model) {
                    /* TODO: Verificar que se pueda actualizar */
                    return ($model->tipo_archivo_aspirante_id == 1 || count($model->cargosActivos) > 0) ? '' : Html::button('<svg class="svg-inline--fa fa-pencil-alt fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="pencil-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg><!-- <span class="fas fa-pencil-alt" aria-hidden="true"></span> -->',
                                    [
                                        'value' => $url,
                                        'title' => Yii::t('app', 'Actualizar'),
                                        'class' => 'showModalButton botongrid',
                                        'data-pjax' => '0',
                                    ]
                    );
                },
                'delete' => function ($url, $model) {
                    /* TODO: Verificar que se pueda borrar */
                    return ($model->tipo_archivo_aspirante_id == 1 || count($model->cargos) > 0) ? '' : Html::a('<svg class="svg-inline--fa fa-trash-alt fa-w-14" aria-hidden="true" data-prefix="fas" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M0 84V56c0-13.3 10.7-24 24-24h112l9.4-18.7c4-8.2 12.3-13.3 21.4-13.3h114.3c9.1 0 17.4 5.1 21.5 13.3L312 32h112c13.3 0 24 10.7 24 24v28c0 6.6-5.4 12-12 12H12C5.4 96 0 90.6 0 84zm416 56v324c0 26.5-21.5 48-48 48H80c-26.5 0-48-21.5-48-48V140c0-6.6 5.4-12 12-12h360c6.6 0 12 5.4 12 12zm-272 68c0-8.8-7.2-16-16-16s-16 7.2-16 16v224c0 8.8 7.2 16 16 16s16-7.2 16-16V208zm96 0c0-8.8-7.2-16-16-16s-16 7.2-16 16v224c0 8.8 7.2 16 16 16s16-7.2 16-16V208zm96 0c0-8.8-7.2-16-16-16s-16 7.2-16 16v224c0 8.8 7.2 16 16 16s16-7.2 16-16V208z"></path></svg><!-- <span class="fas fa-trash-alt" aria-hidden="true"></span> -->',
                                    $url, [
                                'value' => $url,
                                'title' => Yii::t('app', 'Eliminar'),
                                'data-pjax' => '0',
                                'data-confirm' => Yii::t('app', '¿Está seguro de que desea borrar este registro de documento?'),
                                'data-method' => 'post',
                                    ]
                    );
                }
            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    $url = Url::toRoute(['/archivoaspirante/view', 'uuid' => $model->uuid]);
                    return $url;
                }
                if ($action === 'update') {
                    $url = ($model->tipo_archivo_aspirante_id == 1 || count($model->cargosActivos) > 0) ? '' : Url::toRoute(['/archivoaspirante/update', 'uuid' => $model->uuid]);
                    return $url;
                }
                if ($action === 'delete') {
                    $url = ($model->tipo_archivo_aspirante_id == 1 || count($model->cargos) > 0) ? '' : Url::toRoute(['/archivoaspirante/delete', 'uuid' => $model->uuid]);
                    return $url;
                }
            }
        ],
    ],
    'summary' => '',
]);
