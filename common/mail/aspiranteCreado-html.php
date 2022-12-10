<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $aspirante common\models\Aspirante */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $aspirante->verification_token]);
$deleteLink = Yii::$app->urlManager->createAbsoluteUrl(['site/delete-email', 'token' => $aspirante->delete_token]);
$identificacion = substr($aspirante->identificacion, 0, 2) . str_repeat('*', strlen($aspirante->identificacion) - 4) . substr($aspirante->identificacion, -2);
$celular = substr($aspirante->celular, 0, 2) . str_repeat('*', strlen($aspirante->celular) - 4) . substr($aspirante->celular, -2);
?>
<div class="password-reset">
    <p><strong><?= Html::encode($aspirante->nombres) ?> <?= Html::encode($aspirante->apellidos) ?></strong> ha creado un usuario en el aplicativo <?= Yii::$app->name ?></p>
    <p>Los datos que se han ingresado son:</p>
    <ul>
        <li><strong>Usuario:</strong> <?= Html::encode($aspirante->correo_electronico) ?></li>
        <li><strong>Documento:</strong> <?= Html::encode($aspirante->tipoIdentificacion->abreviatura . " " . $identificacion) ?></li>
        <li><strong>Celular:</strong> <?= Html::encode($celular) ?></li>
    </ul>
    <p>Si considera que la información mostrada es correcta dé clic en el siguiente enlace para validar este correo electrónico:</p>
    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
    <p>Si considera que la información mostrada no es correcta o usted no ha solicitado este registro por favor dé clic en el siguiente enlace para eliminar este correo electrónico:</p>
    <p><?= Html::a(Html::encode($deleteLink), $deleteLink) ?></p>
</div>
