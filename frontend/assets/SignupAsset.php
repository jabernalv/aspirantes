<?php

namespace frontend\assets;

use yii\web\AssetBundle;

//use kartik\base\AssetBundle;

/**
 * Main aspirantes application asset bundle.
 */
class SignupAsset extends AssetBundle {

    function __construct($config = []) {
        parent::__construct($config);
    }

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/camara.css',
        '/css/contact-form.css',
    ];
    public $js = [
        '/js/camara.js',
        '/js/jsencrypt.min.js',
    ];
    public $depends = [
        \yii\web\JqueryAsset::class,
    ];

}
