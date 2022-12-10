<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\assets;
use yii\web\AssetBundle;
//use kartik\base\AssetBundle;


class ModernbusinessAsset extends AssetBundle {
    
    
    function __construct($config = []) {
        parent::__construct($config);
        //$this->js[] = 'js/creative.min.js?' . time();
        $this->css[] = 'vendor/fontawesome-free/css/fontawesome.min.css';
        $this->css[] = '//fonts.googleapis.com/css?family=Helvetica:400,700,400italic,700italic';
        $this->css[] = '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800';
        $this->css[] = 'css/modern-business.css?' . time();
        $this->css[] = 'css/build.css?' . time();
    }

    public $sourcePath = __DIR__ . '/../../common/themes/modernbusiness';
    public $css = [
    ];
    public $js = [
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];

}
