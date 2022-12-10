<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use kartik\form\ActiveForm;
use yii\helpers\Url;

$this->title = 'Registro';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/css/contact-form.css?' . time());
$this->registerCssFile('/css/camara.css?' . time());
?>
<nav>
    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="far fa-address-book" style="font-size: 24px;"></i>&nbsp;&nbsp;Datos</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-info-circle" style="font-size: 24px;"></i>&nbsp;&nbsp;Ayuda</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'form-signup',
                    'enableClientValidation' => true,
                    'encodeErrorSummary' => false,
                    'errorSummaryCssClass' => 'help-block',
                    'options' => ['autocomplete' => 'off', 'class' => 'popup-form', 'enctype' => 'multipart/form-data', 'role' => 'form']]);
        ?>
        <div class="site-signup">
            <div class="row">
                <div class="col" id="message-signup"></div>
            </div>
            <?=
            $this->render('_formsignup', [
                'model' => $model,
                'form' => $form,
            ])
            ?>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="row"><div class="col">Por favor diligencie los campos para registrarse. Tenga presente que la dirección IP será guardada.</div></div>
    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div id="ayudasignup"a
        <?=
        $this->render('faqssignup', [
        ])
        ?>></div>
    </div>
</div>
<canvas id="canvasfotoacargar" style="display: none;"></canvas>
<?php
$this->registerJsFile('/js/camara.js?' . time(), ['depends' => [yii\web\JqueryAsset::class]]);
$this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/pdf.js/2.3.200/pdf.min.js', ['depends' => [yii\web\JqueryAsset::class]]);
$this->registerJsFile('/js/jsencrypt.min.js', ['depends' => [yii\web\JqueryAsset::class]]);
// Ejemplos de pdf.js https://mozilla.github.io/pdf.js/examples/
$js = <<< JS
$("#faqslink").html("");
console.log(navigator.sayswho);
JS;
$this->registerJs($js);
