<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $aspirante common\models\Aspirante */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $aspirante->verification_token]);
$deleteLink = Yii::$app->urlManager->createAbsoluteUrl(['site/delete-email', 'token' => $aspirante->delete_token]);
$identificacion = substr($aspirante->identificacion, 0, 2) . str_repeat('*', strlen($aspirante->identificacion) - 4) . substr($aspirante->identificacion, -2);
$celular = substr($aspirante->celular, 0, 2) . str_repeat('*', strlen($aspirante->celular) - 4) . substr($aspirante->celular, -2);
?>
<?= $aspirante->nombres ?> <?= $aspirante->apellidos ?> ha creado un usuario en el aplicativo <?= Yii::$app->name ?>.
Los datos ingresados son:
Usuario <?= $aspirante->correo_electronico ?>.
Documento: <?= $aspirante->tipoIdentificacion->abreviatura . " " . $identificacion ?>
Celular: <?= $celular ?>

Si considera que la información mostrada es correcta copie y pegue el siguiente enlace en un navegador para validar este correo electrónico:

<?= $verifyLink ?>

Si considera que la información mostrada no es correcta o usted no ha solicitado este registro por favor copie y pegue el siguiente enlace en un navegador para eliminar este correo electrónico:

<?= $deleteLink ?>
