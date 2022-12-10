<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\assets;
use yii\web\AssetBundle;
//use kartik\base\AssetBundle;


class MaterialkitAsset extends AssetBundle {
    
    
    function __construct($config = []) {
        parent::__construct($config);
        $this->css[] = '//fonts.googleapis.com/css?family=Helvetica:400,700,400italic,700italic';
        $this->css[] = '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800';
        $this->css[] = '//fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons';
        $this->css[] = 'assets/css/material-kit.css?v=2.0.6&' . time();
        $this->js[] = 'assets/js/core/popper.min.js';
        $this->js[] = 'assets/js/core/bootstrap-material-design.min.js';
        $this->js[] = 'assets/js/plugins/moment.min.js';
    }

    public $sourcePath = __DIR__ . '/../../common/themes/material-kit';
    public $css = [
    ];
    public $js = [
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];

}
