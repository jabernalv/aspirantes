<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Preguntas frecuentes';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/css/contact-form.css?' . time());
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="mb-4" id="accordion" role="tablist" aria-multiselectable="true">
        <?php if (Yii::$app->user->isGuest) : ?>
            <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                    <h2 class="mb-0">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Cómo registrarse</a>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <a href="#">
                                    <img class="img-fluid rounded mb-3 mb-md-0" src="/img/faq01_registrese.png?<?= time()?>" alt="Imagen regístrese">
                                </a>
                            </div>
                            <div class="col">
                                <h3>Presione el botón [Regístrese] en la parte superior</h3>
                                <p>Utilice un navegador web moderno, por ejemplo <a href="https://www.google.com/chrome/">Google Chrome</a>, <a href="https://www.opera.com/es/download">Opera</a>, <a href="https://www.mozilla.org/firefox/download/thanks/">Mozilla Firefox</a> o <a href="https://www.microsoft.com/windows/microsoft-edge">Microsoft Edge</a>. No utilice Microsoft Internet Explorer.
                                <p>Debe dar clic en el botón</p>
                                <a class="btn btn-primary" href="<?= Url::to(['/site/signup']) ?>">Regístrese
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                                <p>para acceder al formulario de registro.</p>
                            </div>
                        </div>
                        <hr>
                        <div id="ayudasignup"></div>
                        <hr>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-header" role="tab" id="headingTwo">
                <h2 class="mb-0">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Cómo cambiar la contraseña</a>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" role="tab" id="headingThree">
                <h2 class="mb-0">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Cómo cargar documentos de soporte de experiencia y estudios</a>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" role="tab" id="headingThree">
                <h2 class="mb-0">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Cómo aplicar a un proceso de selección</a>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$urlfassignup = Url::to(['/site/faqssignup']);
$js = <<< JS
$("#ayudasignup").load("$urlfassignup");
$('#accordion .collapse').attr("data-parent","#accordion");
$('#accordion .collapse').collapse('hide');
JS;
$this->registerJs($js);
