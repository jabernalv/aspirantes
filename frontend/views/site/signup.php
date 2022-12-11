<?php

use kartik\form\ActiveForm;
use yii\helpers\Url;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Registro';
$this->params['breadcrumbs'][] = $this->title;
?>
<ul class="nav nav-tabs flex-column flex-sm-row nav-fill" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
            <i class="far fa-address-book" style=" font-size: 24px;"></i>&nbsp;&nbsp;Datos
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
            <i class="fas fa-info-circle" style="font-size: 24px;"></i>&nbsp;&nbsp;Ayuda
        </button>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="site-signup">
            <div class="row">
                <div class="col" id="message-signup"></div>
            </div>
            <?=
            $this->render('_formsignup', [
                'model' => $model,
            ])
            ?>
        </div>
        <div class="row">
            <div class="col">Por favor diligencie los campos para registrarse. Tenga presente que la dirección IP será
                guardada.
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div id="ayudasignup">
            <?=
            $this->render('faqssignup', [
            ])
            ?>
        </div>
    </div>
</div>
<canvas id="canvasfotoacargar" style="display: none;"></canvas>
<?php JSRegister::begin(); ?>
<script>
    $("#faqslink").html("");
</script>
<?php JSRegister::end(); ?>
