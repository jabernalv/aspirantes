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
    }

    public $sourcePath = __DIR__ . '/../../common/themes/modernbusiness';
    public $css = [
        //'vendor/fontawesome-free/css/fontawesome.min.css',
        //'//fonts.googleapis.com/css?family=Helvetica:400,700,400italic,700italic',
        //'//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800',
        'css/modern-business.css',
        'css/build.css',
    ];
    public $js = [
        //'js/creative.min.js',
    ];
    public $depends = [
        \frontend\assets\AppAsset::class,
    ];

}
