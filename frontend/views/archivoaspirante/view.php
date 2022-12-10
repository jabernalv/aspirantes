<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ArchivoAspirante */

$this->title = $model->uuid;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ArchivoAspirantes'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="archivo_aspirante-view">
    <div class="row">
        <div class="col-lg-12">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'uuid',
                    //'aspirante_uuid',
                    [
                        'attribute' => 'tipo_archivo_aspirante_id',
                        'value' => $model->tipoArchivoAspirante->nombre,
                    ],
                    'comentarios_aspirante',
                //'ruta_web',
                //'md5',
                //'created_at',
                //'modified_at',
                ],
            ])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?=
            \yii2assets\pdfjs\PdfJs::widget([
                'width' => '100%',
                'url' => Url::toRoute(['/archivoaspirante/pdf', 'uuid' => $model->uuid]),
                'buttons' => [
                    'presentationMode' => true,
                    'openFile' => false,
                    'print' => false,
                    'download' => false,
                    'viewBookmark' => false,
                    'secondaryToolbarToggle' => false,
                ]
            ]);
            ?>
        </div>
    </div>
</div>
