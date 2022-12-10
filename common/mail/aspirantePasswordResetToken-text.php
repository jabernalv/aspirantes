<?php

/* @var $this yii\web\View */
/* @var $aspirante common\models\Aspirante */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $aspirante->password_reset_token]);
?>
Se ha solicitado un cambio de contraseña para el usuario <?= $aspirante->nombres ?> <?= $aspirante->apellidos ?> en el aplicativo <?= Yii::$app->name ?>,

Puede cambiar su contraseña copiando y pegando el siguiente enlace en un navegador:

<?= $resetLink ?>
