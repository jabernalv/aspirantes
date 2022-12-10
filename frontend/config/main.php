<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php',
        require __DIR__ . '/../../common/config/params-local.php',
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-aspirantes',
    'name' => 'Registro de aspirantes',
    'language' => 'es',
    'sourceLanguage' => 'es',
    'timeZone' => 'America/Bogota',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-aspirantes',
        ],
        'user' => [
            'identityClass' => 'common\models\Aspirante',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-aspirantes', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the aspirantes
            'name' => 'advanced-aspirantes',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/sbclean',
                //'baseUrl' => '@web/themes/sbclean',
                'baseUrl' => '@web',
                'pathMap' => [
                    '@app/views' => '@app/themes/sbclean',
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.office365.com',
                'username' => 'admin@dirigiendoproyectos.com',
                'password' => 'E5t4mbuL$',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
    /*
      'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
      ],
      ],
     */
    ],
    'params' => $params,
];
