<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ArchivoProceso */

$this->title = $model->id;
\yii\web\YiiAsset::register($this);
?>
<div class="archivo-proceso-view">
            <?=
            \yii2assets\pdfjs\PdfJs::widget([
                'width' => '100%',
                'url' => $model->ruta_web,
                'buttons' => [
                    'presentationMode' => false,
                    'openFile' => false,
                    'print' => false,
                    'download' => false,
                    'viewBookmark' => false,
                    'secondaryToolbarToggle' => false,
                ]
            ]);
            ?>
</div>
