<?php

namespace frontend\assets;

use bestyii\bootstrap\icons\assets\BootstrapIconAsset;
use \yii\bootstrap5\BootstrapAsset;
use \yii\web\YiiAsset;
use yii\web\AssetBundle;

/**
 * Main aspirantes application asset bundle.
 */
class AppAsset extends AssetBundle {

    function __construct($config = []) {
        parent::__construct($config);
    }

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/site.css',
        '/css/aspirantes.css',
        '/css/bootstrap-tooltip-custom-class.min.css',
        '/css/whhg.css',
    ];
    public $js = [
        '/js/ajax-modal-popup.js',
        '/js/md5.js',
        '/js/site.js',
        '/js/fonts.js',
        '/js/bootstrap-tooltip-custom-class.min.js',
    ];
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        BootstrapIconAsset::class,
    ];

}
