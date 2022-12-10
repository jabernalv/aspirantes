<?php

namespace frontend\assets;

use yii\web\AssetBundle;

//use kartik\base\AssetBundle;

/**
 * Main aspirantes application asset bundle.
 */
class AppAsset extends AssetBundle {

    function __construct($config = []) {
        parent::__construct($config);
        $this->js[] = '/js/ajax-modal-popup.js?' . time();
        $this->js[] = '/js/md5.js';
        $this->js[] = '/js/site.js?' . time();
        $this->js[] = '//mozilla.github.io/pdf.js/build/pdf.js';
       // $this->js[] = ['//cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', 'integrity' => "sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlv]I9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo", 'crossorigin' => "anonymous"];
        //$this->js[] = '//www.google.com/recaptcha/api.js?'; // . time();
        $this->css[] = '/css/site.css?' . time();
        $this->css[] = '/css/aspirantes.css?' . time();
        //$this->css[] = '/elusive-icons-2.0.0/css/elusive-icons.min.css?'; // . time();
        //$this->css[] = '//d1azc1qln24ryf.cloudfront.net/114779/Socicon/style-cf.css?'; // . time();
        //$this->css[] = '/css/whhg.css?'; // . time();
        $this->css[] = '//fonts.googleapis.com/icon?family=Material+Icons';
        //$this->css[] = '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css';
    }

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];

}
