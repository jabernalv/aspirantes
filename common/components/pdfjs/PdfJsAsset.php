<?php

namespace common\components\pdfjs;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * PdfJs Asset bundle
 * @author Sathit Seethaphon <dixonsatit@gmail.com>
 */
class PdfJsAsset extends AssetBundle {
    public $sourcePath = '@common/components/pdfjs/assets';

    public $js = [
        'build/pdf.js',
        'build/pdf.worker.js',
        //['web/debugger.js', 'type' => 'module'],
        'web/viewer.js'
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD
    ];

    public $css = [
        'web/viewer.css',
        //'web/debugger.css'
    ];
}

?>
