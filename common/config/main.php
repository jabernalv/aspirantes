<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<uuid:[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<uuid:[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
    ],
    'modules' => [
        'pdfjs' => [
            'class' => '\yii2assets\pdfjs\Module',
            'waterMark' => [
                'text' => 'Documento confidencial',
                'color' => 'red',
                'alpha' => '0.3',
            ]
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
// enter optional module parameters below - only if you need to  
// use your own export download action or custom translation 
// message source
// 'downloadAction' => 'gridview/export/download',
// 'i18n' => []
        ],
    ],
];
