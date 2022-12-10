<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $usuario common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $usuario->US_PASSWORD_RESET_TOKEN]);
?>
<div class="password-reset">
    <p>Se ha solicitado un cambio de contraseña para el usuario <strong><?= Html::encode($usuario->US_USUARIO) ?></strong> en el aplicativo <?= Yii::$app->name ?>,</p>
    <p>Dé clic en el siguiente enlace para cambiar su contraseña:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
