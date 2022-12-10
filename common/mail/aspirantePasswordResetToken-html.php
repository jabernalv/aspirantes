<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $aspirante common\models\Aspirante */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $aspirante->password_reset_token]);
?>
<div class="password-reset">
    <p>Se ha solicitado un cambio de contraseña para el usuario <strong><?= Html::encode($aspirante->nombres) ?> <?= Html::encode($aspirante->apellidos) ?></strong> en el aplicativo <?= Yii::$app->name ?>,</p>
    <p>Dé clic en el siguiente enlace para cambiar su contraseña:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
