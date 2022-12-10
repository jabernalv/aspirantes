<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\grid\CheckboxColumn;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ArchivoAspiranteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $identificacion common\models\search\ArchivoAspirante */
/* @var $seleccionados string */
//$this->params['breadcrumbs'][] = $this->title;
Pjax::begin();
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
        //['class' => 'yii\kartik\SerialColumn'],
        [
            'class' => CheckboxColumn::class,
            'rowSelectedClass' => GridView::TYPE_INFO,
            'name' => 'AspiranteCargo[archivo_aspirantes][]',
            'header' => '',
            'checkboxOptions' => function($model, $key, $index, $column) use ($proceso_id) {
                $bool = $model->seleccionadoencargo($cargo_id);
                return [
                    'class' => 'check_archivo_aspirante',
                    'checked' => $bool
                ];
            },
        //'attribute' => 'selected',
        ],
        //'uuid',
        //'aspirante_uuid',
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'tipo_archivo_aspirante_id',
            //'value' => 'category.name',
            'value' => function ($model) {
                return $model->tipoArchivoAspirante->nombre;
            },
            'format' => 'raw',
            'enableSorting' => false,
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'comentarios_aspirante',
            'format' => 'raw',
            'enableSorting' => false,
        ],
        //'ruta_web',
        //'md5',
        //'created_at',
        //'modified_at',
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{view}',
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
            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    $url = Url::toRoute(['/archivoaspirante/view', 'uuid' => $model->uuid]);
                    return $url;
                }
            }
        ],
    ],
    'summary' => '',
]);
Pjax::end();
$identificacion_uuid = $identificacion->uuid;
$js = <<< JS
var _marcadaidentificacion=false;
$.each("$seleccionados".split(","), function(index,_value){if(_value!=""){ $('.check_archivo_aspirante[value="'+_value+'"]').prop('checked', true);}});
$('.check_archivo_aspirante[value="$identificacion_uuid"]').prop('checked', true);
$('.check_archivo_aspirante').on('change', function(e){
  if($(this).val()=="$identificacion_uuid"&&_marcadaidentificacion==true){
    e.preventDefault();
    $(this).prop('checked', true);
  }else{
    var archivo_aspirantesincluidos = $('.check_archivo_aspirante:checkbox:checked');
    $('#aspirantecargo-numero_archivo_aspirantes').val($('.check_archivo_aspirante:checkbox:checked').length);
    $("#aspirantecargo-archivo_aspirantes_seleccionados").val("");
    $.each(archivo_aspirantesincluidos, function() { $("#aspirantecargo-archivo_aspirantes_seleccionados").val($("#aspirantecargo-archivo_aspirantes_seleccionados").val() + this.value + ","); });
    _marcadaidentificacion=true;
  }
});
$('.check_archivo_aspirante[value="$identificacion_uuid"]').trigger('change');
JS;
$this->registerJs($js);
