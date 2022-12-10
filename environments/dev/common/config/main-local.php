<?php
$array_ini = parse_ini_file("config.ini");
$dbname = $array_ini['database'];
$username = $array_ini['user'];
$password = $array_ini['password'];
$host = $array_ini['host'];
$charset = $array_ini['default-character-set'];
$port = $array_ini['port'];

return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname,
            'username' => $username,
            'password' => $password,
            'charset' => $charset,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
