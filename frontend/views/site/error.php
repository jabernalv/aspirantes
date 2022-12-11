<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = $name;
?>
<div class="site-error">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <p>
        El error mostrado ocurrió mientras el servidor Web estaba procesando su solicitud.
    </p>
    <p>
        Por favor <?= Html::a('contáctenos', Url::to(['/site/contact']), []); ?> si considera que este es un error del servidor. Gracias y disculpe las molestias.
    </p>
</div>
