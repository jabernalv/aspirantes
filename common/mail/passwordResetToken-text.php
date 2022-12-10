<?php

/* @var $this yii\web\View */
/* @var $usuario common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $usuario->US_PASSWORD_RESET_TOKEN]);
?>
Se ha solicitado un cambio de contraseña para el usuario <?= $usuario->US_USUARIO ?> en el aplicativo <?= Yii::$app->name ?>,

Puede cambiar su contraseña copiando y pegando el siguiente enlace en un navegador:

<?= $resetLink ?>
