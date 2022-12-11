<?php
/*
 * Basado y mejorado a partir de https://programacion.net/articulo/como_crear_un_form_wizard_con_bootstrap_que_este_validado_con_jquery_1697 //-->
 */

use frontend\assets\SignupAsset;
use frontend\models\SignupForm;
use kartik\form\ActiveForm;
use yii\bootstrap5\Html;
use kartik\select2\Select2;
use common\helpers\Dropdowns;
use common\components\PasswordTextBox;
use yii\helpers\Url;
use yii\captcha\Captcha;
use richardfan\widget\JSRegister;
use common\components\pdfjs\PdfJsAsset;

/* @var $this yii\web\View */
/* @var $form kartik\form\ActiveForm */
/* @var $model SignupForm */
SignupAsset::register($this);
$pdfJsAsset = PdfJsAsset::register($this);
?>
<hr>
<?php
$form = ActiveForm::begin([
    'id' => 'form-signup',
    'type' => ActiveForm::TYPE_FLOATING,
    'validationUrl' => Url::to('/site/validatesignup'),
    'enableClientValidation' => true,
    'encodeErrorSummary' => false,
    'errorSummaryCssClass' => 'help-block',
    'options' => [
        'autocomplete' => 'off',
        'class' => 'popup-form',
        'enctype' => 'multipart/form-data',
        'role' => 'form',
    ],
    'formConfig' => [
        'showLabels' => false,
        'showHints' => true,
    ],
]);
?>
<div class="mt-5">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step">
                <a href="#step-1" type="button" class="btn btn-primary btn-circle">
                    <i class="bi bi-envelope-at"></i>
                </a>
                <p>Correo</p>
            </div>
            <div class="stepwizard-step disabled">
                <a href="#step-2" type="button" class="btn btn-default btn-circle disabled">
                    <i class="icon-mobile"></i>
                </a>
                <p>Autenticación</p>
            </div>
            <div class="stepwizard-step disabled">
                <a href="#step-3" type="button" class="btn btn-default btn-circle disabled">
                    <i class="icon-avatar"></i>
                </a>
                <p>Datos personales</p>
            </div>
            <div class="stepwizard-step disabled">
                <a href="#step-4" type="button" class="btn btn-default btn-circle disabled">
                    <i class="icon-camera"></i></a>
                <p>Fotografía</p>
            </div>
            <div class="stepwizard-step disabled">
                <a href="#step-5" type="button" class="btn btn-default btn-circle disabled">
                    <i class="icon-contact-businesscard"></i></a>
                <p>Documento ID</p>
            </div>
            <div class="stepwizard-step disabled">
                <a href="#step-6" type="button" class="btn btn-default btn-circle disabled">
                    <i class="icon-key"></i></a>
                <p>Contraseña</p>
            </div>
            <div class="stepwizard-step disabled">
                <a href="#step-7" type="button" class="btn btn-default btn-circle disabled">
                    <i class="bi bi-check2-circle"></i>
                </a>
                <p>Confirmación</p>
            </div>
        </div>
    </div>
    <section class="row setup-content" id="step-1">
        <div class="col-md-12">
            <legend>Correo electrónico</legend>
            <div class="row">
                <div class="col-md-8">
                    <ul>
                        <li class="helpli noshow" id="help-for-signupform-correo_electronico">
                            Ingrese el correo electrónico. Debe ser un correo electrónico real y con formato válido.
                            <ul>
                                <li>Solo se permite que se registre una vez por cada buzón de correo.</li>
                                <li>Si sale el error <span style="color:#ce0606 !important">Correo electrónico ya registrado pero sin verificar.</span>,
                                    quiere decir que ya se hizo un registro con ese buzón de correo pero no se ha
                                    realizado la verificación, busque en su buzón el correo de verificación o solicite
                                    que se le
                                    <?= Html::a("envíe de nuevo", Url::to(['/site/resend-verification-email'])) ?>.
                                </li>
                                <li>Si sale el error <span style="color:#ce0606 !important">Correo electrónico ya registrado y verificado.</span>,
                                    quiere decir que ya se hizo un registro con ese buzón de
                                    correo, <?= Html::a("ingrese al sistema", Url::to(['/site/logi'])) ?> usando el
                                    correo y contraseña registrados. Si ha olvidado la contraseña
                                    puede <?= Html::a("recuperarla aquí", Url::to(['/site/requests-password-reset'])) ?>
                                    .
                                </li>
                                <li>Si sale el error <span style="color:#ce0606 !important">Correo electrónico no permitido.</span>,
                                    quiere decir que está intentando el registro con un buzón de correo falso o de
                                    un dominio bloqueado, debe cambiar el correo.
                                </li>
                                <li>El correo electrónico funciona como usuario del sistema y por lo tanto NO podrá
                                    ser cambiado más adelante, use un correo personal al cual pueda acceder siempre.
                                </li>
                            </ul>
                        </li>
                        <li class="helpli noshow" id="help-for-signupform-repite_correo_electronico">Repita el
                            correo electrónico que ingresó en el campo anterior, debe coincidir por completo.
                        </li>
                        <li class="helpli noshow" id="help-for-signupform-captcha">
                            Ingrese el texto que se ve en la imagen.
                            Si le parece muy complicada la imagen puede dar clic sobre ella para cambiar el
                            texto que se muestra.
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <fieldset>
                        <div class="form-row">
                            <div class="col">
                                <?=
                                $form->field($model, 'correo_electronico', [
                                    'enableAjaxValidation' => true,
                                    'addon' => [
                                        'prepend' => [
                                            'content' => '<i class="bi bi-envelope-at-fill"></i>',
                                        ],
                                    ],
                                ])
                                    ->textInput([
                                        'type' => 'email',
                                        'maxlength' => true,
                                        'class' => 'form-control nocopypaste triminput correosaspirante focus',
                                        'title' => 'Ingrese su correo electrónico.',
                                    ])
                                ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <?=
                                $form->field($model, 'repite_correo_electronico', [
                                    'addon' => [
                                        'prepend' => [
                                            'content' => '<i class="bi bi-envelope-exclamation-fill"></i>',
                                        ],
                                    ],
                                ])
                                    ->textInput([
                                        'type' => 'email',
                                        'maxlength' => true,
                                        'class' => 'form-control nocopypaste triminput correosaspirante',
                                        'title' => 'Ingrese de nuevo el correo electrónico.',
                                        'data-spanid' => 'span_correoelectronico',
                                    ])
                                ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <?=
                                $form->field($model, 'captcha', [
                                    'enableAjaxValidation' => true,
                                ])->widget(Captcha::class, [
                                    'template' => '<div class="col-xs-12">{image}</div><div class="input-group"><span class="input-group-text"><i class="bi bi-code-slash"></i></span>{input}</div>',
                                    'options' => [
                                        'placeholder' => 'Ingrese el texto que se ve en la imagen',
                                        'class' => 'form-control',
                                        'title' => 'Ingrese el texto que se ve en la imagen.',
                                    ]
                                ]);
                                ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md">
                    <button class="btn btn-primary nextBtn float-right" type="button">
                        Siguiente <i class="bi bi-chevron-double-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="row setup-content" id="step-2">
        <div class="col-md-12">
            <legend>Datos de autenticación</legend>
            <div class="row">
                <div class="col-md-8">
                    <ul>
                        <li class="helpli noshow" id="help-for-signupform-tipo_identificacion_select2">
                            Seleccione el tipo de identificación.
                        </li>
                        <li class="helpli noshow" id="help-for-signupform-identificacion">
                            Ingrese el documento de identificación.
                            <ul>
                                <li>No podrá ser cambiado más adelante.</li>
                                <li>Solo se permite que se registre una vez por cada documento de identificación.
                                </li>
                                <li>Debe ser el mismo que aparece en el archivo .pdf que se solicitará en el paso 4,
                                    esto será verificado antes de autorizar el ingreso al sistema.
                                </li>
                                <li>Si sale el error <span style="color:#ce0606 !important">Identificación ya registrada y verificada.</span>,
                                    quiere decir que ya se hizo un registro con ese número de identificación y se
                                    realizó la verificación
                                    correspondiente, <?= Html::a("ingrese al sistema", Url::to(['/site/logi'])) ?>
                                    usando el correo y contraseña registrados. Si ha olvidado la contraseña
                                    puede <?= Html::a("recuperarla aquí", Url::to(['/site/requests-password-reset'])) ?>
                                    .
                                </li>
                            </ul>
                        </li>
                        <li class="helpli noshow" id="help-for-signupform-celular">
                            Ingrese el celular que usará para validar el registro.
                            <ul>
                                <li>Recibirá un Token en mensaje de texto para validar que el celular existe. Solo
                                    se permiten números de celular de Colombia.
                                </li>
                                <li>El mismo número de celular solo se puede utilizar para registrar dos personas
                                    diferentes.
                                </li>
                                <li>Si sale el error
                                    <span style="color:#ce0606 !important"># celular ya usado.</span>,
                                    quiere decir que ya se realizaron dos registros con ese número de celular, debe
                                    usar otro número de celular.
                                </li>
                                <li>No podrá ser cambiado más adelante, use un número de celular personal al cual
                                    pueda acceder siempre.
                                </li>
                            </ul>
                        </li>
                        <li class="helpli noshow" id="help-for-obtener-token-button">
                            Cuando haya diligenciado todos los datos anteriores se habilitará el botón Token. Dé
                            clic en el botón para recibir el Token en mensaje de texto.
                        </li>
                        <li class="helpli noshow" id="help-for-signupform-token">
                            Ingrese el token que recibe en mensaje de texto enviado al celular que ingresó.
                        </li>
                    </ul>
                </div>
                <div class="col-md">
                    <fieldset>
                        <div class="form-row">
                            <div class="col">
                                <?=
                                $form
                                    ->field($model, 'tipo_identificacion_id', ['addon' => ['prepend' => ['content' => '<i class="bi bi-person-badge-fill"></i>']]])
                                    ->widget(Select2::class, [
                                        'data' => Dropdowns::tiposidentificaciondropdown(),
                                        'options' => [
                                            'placeholder' => 'Seleccione el tipo ID',
                                            'multiple' => false,
                                            'class' => 'focus',
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'class' => 'cccclass',
                                        ],
                                    ]);
                                ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <?=
                                $form->field($model, 'identificacion', ['enableAjaxValidation' => true, 'addon' => ['prepend' => ['content' => '<i class="icon-contact-businesscard"></i>']]])
                                    ->textInput(['maxlength' => true, 'type' => 'number', 'step' => '1', 'min' => '1', 'placeholder' => 'Documento de identificación', 'class' => 'form-control nocopypaste', 'data-spanid' => 'span_documentoidentificacion'])
                                    ->label(false)
                                ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <?=
                                $form->field($model, 'celular', ['enableAjaxValidation' => true, 'addon' => ['prepend' => ['content' => '<i class="bi bi-telephone-fill"></i>']]])
                                    ->textInput(['maxlength' => '10', 'type' => 'number', 'step' => '1', 'min' => '3000000000', 'max' => '3999999999', 'placeholder' => 'Sólo celulares de Colombia', 'autocomplete' => 'nope', 'class' => 'form-control nocopypaste', 'data-spanid' => 'span_celular'])
                                    ->label(false)
                                ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md">
                                <?= Html::button('<i class="icon-mobile"></i> Token', ['class' => 'btn btn-primary', 'id' => 'obtener-token-button', 'disabled' => 'disabled']) ?>
                            </div>
                            <div class="col-md-8">
                                <?=
                                $form->field($model, 'token', ['enableAjaxValidation' => true, 'addon' => ['prepend' => ['content' => '<i class="bi bi-sticky-fill"></i>']]])
                                    ->textInput([/* 'readonly' => 'readonly', */ 'maxlength' => '6', 'type' => 'number', 'step' => '1', 'min' => '100000', 'max' => '999999', 'placeholder' => 'Dé clic en [TOKEN] para enviarlo a su celular', 'autocomplete' => 'nope', 'class' => 'form-control nocopypaste', 'tabindex' => '-1'])
                                    ->label(false)
                                ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md">
                    <button class="btn btn-secondary prevBtn float-left" type="button" tabindex="-1">
                        <i class="bi bi-chevron-double-left"></i> Anterior
                    </button>
                    <button class="btn btn-primary nextBtn float-right" type="button">
                        Siguiente <i class="bi bi-chevron-double-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="row setup-content" id="step-3">
        <div class="col-md-12">
            <legend>Datos personales</legend>
            <div class="row">
                <div class="col-md-8">
                    <ul>
                        <li class="helpli noshow" id="help-for-signupform-nombres">
                            Ingrese los nombres tal y como aparecen en el documento de identidad.
                            <ul>
                                <li>Tenga presente que esta información se validará contra el documento .pdf que
                                    cargue.
                                </li>
                                <li>No podrá ser cambiado más adelante.</li>
                            </ul>
                        </li>
                        <li class="helpli noshow" id="help-for-signupform-apellidos">
                            Ingrese los apellidos tal y como aparecen en el documento de identidad.
                            <ul>
                                <li>Tenga presente que esta información se validará contra el documento .pdf que
                                    cargue.
                                </li>
                                <li>No podrá ser cambiado más adelante.</li>
                            </ul>
                        </li>
                        <li class="helpli noshow" id="help-for-signupform-fecha_nacimiento">
                            Ingrese la fecha de nacimiento en formato dd/mm/aaaa, tal y como aparece en el documento
                            de identidad.
                            <ul>
                                <li>Tenga presente que esta información se validará contra el documento .pdf que
                                    cargue.
                                </li>
                                <li>No podrá ser cambiado más adelante.</li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-md">
                    <fieldset>
                        <div class="form-row">
                            <div class="col">
                                <?=
                                $form->field($model, 'nombres', ['addon' => ['prepend' => ['content' => '<i class="fa fa-user"></i>']]])
                                    ->textInput(['maxlength' => true, 'placeholder' => 'Nombres. Tal como aparece en el documento de identidad', 'class' => 'form-control nocopypaste triminput nombresaspirante focus', 'title' => 'Ingrese su nombre completo.', 'data-spanid' => 'span_nombres'])
                                    ->label(false)
                                ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <?=
                                $form->field($model, 'apellidos', ['addon' => ['prepend' => ['content' => '<i class="fa fa-user"></i>']]])
                                    ->textInput(['maxlength' => true, 'placeholder' => 'Apellidos. Tal como aparece en el documento de identidad', 'class' => 'form-control nocopypaste triminput nombresaspirante', 'title' => 'Ingrese sus apellidos completos.', 'data-spanid' => 'span_apellidos'])
                                    ->label(false)
                                ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <?php
                                $date = new \DateTime();
                                date_sub($date, date_interval_create_from_date_string('75 years'));
                                $minAgeDate = date_format($date, 'Y-m-d');
                                date_add($date, date_interval_create_from_date_string('60 years'));
                                $maxAgeDate = date_format($date, 'Y-m-d');
                                ?>
                                <?php
                                echo $form->field($model, 'fecha_nacimiento', ['addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']]])->textInput(['type' => 'date', 'min' => $minAgeDate, 'max' => $maxAgeDate, 'data-spanid' => 'span_fechanacimiento',]);
                                ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md">
                    <button class="btn btn-secondary prevBtn float-left" type="button" tabindex="-1">
                        <i class="bi bi-chevron-double-left"></i> Anterior
                    </button>
                    <button class="btn btn-primary nextBtn float-right" type="button">Siguiente
                        <i class="bi bi-chevron-double-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="row setup-content" id="step-4">
        <div class="col-md-12">
            <legend>Fotografía</legend>
            <div class="row">
                <div class="col-md-8">
                    <p>Tome la fotografía con la cámara web</p>
                    <ul>
                        <li class="helpli noshow" id="help-for-listaDeDispositivos">
                            Si tiene varias cámaras seleccione la que va a usar para tomar su fotografía.
                        </li>
                        <li class="helpli noshow" id="help-for-foto-button">
                            Dé clic en el botón [TOMAR FOTO] para registrar su fotografía.
                            <ul>
                                <li>Si tiene varias cámaras debe seleccionar la que va a usar para tomar su
                                    fotografía.
                                </li>
                                <li>La fotografía se validará contra el documento .pdf que cargue para garantizar
                                    que la
                                    persona que se registra es la propietaria del documento de identidad.
                                </li>
                                <li>No podrá ser cambiada más adelante. Puede tomarla varias veces hasta que esté
                                    satisfecho con el resultado.
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-md">
                    <fieldset>
                        <video muted="muted" id="video" class="img-fluid" style="display: none;"></video>
                        <div class="form-row">
                            <div class="col">
                                <select name="listaDeDispositivos" id="listaDeDispositivos" style="font-size: x-small;"
                                        tabindex="-1"></select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <?php echo Html::button('<i class="fa fa-camera-retro"></i> Tomar foto', ['id' => "foto-button", 'class' => "btn btn-primary focus"]) ?>
                                <br>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <canvas id="canvas"></canvas>
                                <br><br>

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <?= $form->field($model, 'foto')->hiddenInput()->label(false); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col">
                                <?= $form->field($model, 'fotoconfirmada', [])->checkbox(); ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md">
                    <button class="btn btn-secondary prevBtn float-left" type="button" tabindex="-1"><i
                                class="bi bi-chevron-double-left"></i> Anterior
                    </button>
                    <button class="btn btn-primary nextBtn float-right" type="button">Siguiente <i
                                class="bi bi-chevron-double-right"></i></button>
                </div>
            </div>
        </div>
    </section>
    <section class="row setup-content" id="step-5">
        <div class="col-md-12">
            <legend>Archivo del documento de identificación</legend>
            <div class="row">
                <div class="col-md-8">
                    <ul>
                        <li class="helpli noshow" id="help-for-documentoidentificacion-button">
                            Cargue el archivo del documento de identificación.
                            <ul>
                                <li>Debe cargar un archivo en formato .pdf.</li>
                                <li>El archivo no debe superar 1 MB de peso.</li>
                                <li>Debe ser un archivo sin contraseña.</li>
                                <li>Asegúrese que puede ver en la parte inferior de manera correcta el archivo antes
                                    de
                                    dar clic en [Siguiente].
                                </li>
                                <li>Recuerde que se validará contra la otra información que ha ingresado.</li>
                                <li>No podrá ser cambiado más adelante.</li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-md">
                    <fieldset>
                        <div class="form-row">
                            <div class="col">
                                <?php
                                echo Html::button("<i class='icon-contact-businesscard'></i> Documento ID", ['class' => 'btn btn-primary focus', 'id' => 'documentoidentificacion-button']);
                                ?>
                                <br><br>
                            </div>
                            <div class="col">
                                <?= $form->field($model, 'documentoidentificacion')->fileInput(['style' => 'display:none;', 'accept' => ".pdf,application/pdf"])->label(false); ?>
                                <?= $form->field($model, 'pdf_correcto')->hiddenInput()->label(false) ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <?= $form->field($model, 'documentoconfirmado', [])->checkbox([]); ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md">
                    <button class="btn btn-secondary prevBtn float-left" type="button" tabindex="-1"><i
                                class="bi bi-chevron-double-left"></i> Anterior
                    </button>
                    <button class="btn btn-primary nextBtn float-right" type="button">Siguiente <i
                                class="bi bi-chevron-double-right"></i></button>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <canvas id="canvaspdf" width="100%"></canvas>
                </div>
            </div>
        </div>
    </section>
    <section class="row setup-content" id="step-6">
        <div class="col-md-12">
            <legend>Contraseña</legend>
            <div class="row">
                <div class="col-md-8">
                    <ul>
                        <li class="helpli noshow" id="help-for-signupform-password_fake">
                            Ingrese la contraseña que va a usar para ingresar al sistema.
                            <ul>
                                <li>La contraseña debe ser de 8 caracteres de largo o más y contener por lo menos 1
                                    letra mayúscula, 1 letra minúscula, 1 número y 1 caracter especial como estos
                                    ($*#@!).
                                </li>
                            </ul>
                        </li>
                        <li class="helpli noshow" id="help-for-signupform-password_repeat_fake">
                            Repita la contraseña que ingresó en el campo contraseña.
                        </li>
                    </ul>
                </div>
                <div class="col-md">
                    <fieldset>
                        <div class="form-row">
                            <div class="col">
                                <?=
                                $form->field($model, 'password', ['addon' => ['prepend' => ['content' => '<i class="fa fa-key"></i>']]])
                                    ->widget(PasswordTextBox::class, [
                                        'options' => [
                                            'placeholder' => 'Contraseña', 'class' => 'focus',
                                        ],
                                    ])
                                    ->label(false);
                                ?>
                                <?= $form->field($model, "enc_password", [])->hiddenInput()->label(false); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <?=
                                $form->field($model, 'password_repeat', ['addon' => ['prepend' => ['content' => '<i class="fa fa-key"></i>']]])
                                    ->widget(PasswordTextBox::class, [
                                        'options' => [
                                            'placeholder' => 'Repita la contraseña',
                                        ],
                                    ])
                                    ->label(false);
                                ?>
                                <?= $form->field($model, "enc_password_repeat", [])->hiddenInput()->label(false); ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md">
                    <button class="btn btn-secondary prevBtn float-left" type="button" tabindex="-1">
                        <i class="bi bi-chevron-double-left"></i> Anterior
                    </button>
                    <button class="btn btn-primary nextBtn float-right" type="button">
                        Siguiente
                        <i class="bi bi-chevron-double-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="row setup-content" id="step-7">
        <div class="col-md-12">
            <fieldset>
                <legend>Confirmación</legend>
                <div class="row">
                    <div class="col">
                        Tenga en cuenta que una vez enviado el formulario no podrá cambiar los siguientes datos:
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <ul>
                            <li>
                                <strong>Nombres:</strong>
                                <span id="span_nombres"></span>
                            </li>
                            <li>
                                <strong>Apellidos:</strong>
                                <span id="span_apellidos"></span>
                            </li>
                            <li>
                                <strong>Correo electrónico:</strong>
                                <span id="span_correoelectronico"></span>
                            </li>
                            <li>
                                <strong>Fotografía.</strong>
                            </li>
                        </ul>
                    </div>
                    <div class="col">
                        <ul>
                            <li>
                                <strong>Fecha de nacimiento:</strong>
                                <span id="span_fechanacimiento"></span>
                            </li>
                            <li>
                                <strong>Documento de identificación:</strong>
                                <span id="span_tipodocumentoidentificacion"></span>
                                <span id="span_documentoidentificacion"></span>
                            </li>
                            <li><strong>Número de celular registrado:</strong> <span id="span_celular"></span></li>
                            <li><strong>Archivo del documento de identificación.</strong></li>
                        </ul>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="form-row">
                            <img id="img-confirm" class="img-fluid">
                        </div>
                    </div>
                    <div class="col">
                        <div id="errorpdf" class="form-row">
                            <div class='alert-danger alert alert-dismissible' role='alert'>
                                Debe cargar el archivo de documento de identificación.
                            </div>
                        </div>
                        <div class="form-row embed-container">
                            <iframe id="viewerpdfconfirm" frameborder="0" scrolling="no" width="400" height="600"
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        Al enviar la información usted acepta los términos y condiciones.<br>
                        ¿Está por completo seguro de que desea enviar el formulario?
                    </div>
                    <div class="col">
                        <?= $form->field($model, 'terminosaceptados', [])->checkbox(['class' => 'focus']); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                    </div>
                    <div class="col">
                        <?= $form->errorSummary($model, []); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md">
                        <button class="btn btn-secondary prevBtn float-left" type="button" tabindex="-1">
                            <i class="bi bi-chevron-double-left"></i> Anterior
                        </button>
                        <?= Html::submitButton('<i class="fa fa-user-check"></i> Registro', [
                                'class' => 'btn btn-custom btn-light nextBtn btn-block float-right',
                                'name' => 'signup-button',
                                'id' => 'signup-button']
                        ) ?>
                    </div>
                </div>
            </fieldset>
        </div>
    </section>
</div>
<?php ActiveForm::end(); ?>
<?php JSRegister::begin(); ?>
<script>
    let celularvalidado = !1,
        correo_electronicovalido = "",
        identificacionvalida = "",
        correo_electronicovalidado = !1,
        identificacionvalidada = !1,
        celular = "",
        identificacion = "",
        correo_electronico = "",
        todovalidado = !1,
        celularvalido = ""
    ;
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')),
        tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        }),
        abreviaturasidentificacion = <?= json_encode(Dropdowns::tiposidentificacionabreviaturasdropdown()); ?>,
        urlsms = '<?= Url::to(['/site/sms']); ?>',
        pk = "MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgECj3EcT/h4Rc4ecgebCHrC3RB0NET29pRP/Gjf6fFZr/Xa6kMSBEuNjoDG/c0Iuu3e+WBDBotDluO5Ru0nfq7XwTQXXMHMgHfM+KMeWBNw48DW5EZTSre2+x3kB92sP0FNWsdeGyEQhqF2fadM+hWdkezRei199hpAW+R3q5w24q5wa57iWR2YXnsLzHa2ttpOjrvUvVz3K9Mp+NjiUlkwBs0fydhT/xyJueBA4UvxPLbezqulmYenlNW3l7o4UnFLyi3lonPkE/jE1Wn8cYcNwKMAroj2KTO5S9H3efspa+iK+oUvaIgpi1gz5zG3ODvqjJfUL35jBG3Kbymvy4adAS9ZbpoB188B34APBhYvhLm2evjwvuPJ4fQCvbmbgsglOwpAtDhjnFIlYdd6XVh9oQB3XZc/sGZrIpkL4CDb/kuKQw58Xa7MFuGmf2dUSeFaMxQwfyv+aa6kqzRYOmqEL6HFxaWyoitZgbl2TppwFOyuJSg3MCmYsm+LmqrDHjNLr2uVQVU4YHCVWQgX5ZJlzDPArW+zhR5Dd1asedg2yyy92XeNpe1PUpLhdehFPcyppvxweecGXzGH+9vkET7PDHx9WOd1+8EWkm7tI9x70BtjQDvkxh+w506SpADE+O2P0RiRHRCzAjkbqqx8Uq17KCucHz5OeHt3hHjzSkUHiS8CAwEAAQ==",
        _formsignup = $('#form-signup'),
        contentCargados = [true],
        navListItems = $('div.setup-panel div a'), // tab nav items
        allWells = $('.setup-content'), // content div
        _data = _formsignup.data("yiiActiveForm"),
        listocelular = function () {
            celularvalido = celular;
            correo_electronicovalido = correo_electronico;
            identificacionvalida = identificacion;
            //$("#signupform-token").prop('readonly',!1); // Hay que activar este
            $("#signupform-token")
                .attr("placeholder", 'Dé clic en el botón [TOKEN] para recibir el token en su celular.')
                .focus();
        },
        setMessage = function (message, tipo) {
            if (!camarahabilitada) {
                $("#message-signup").html(messagecamara);
            } else {
                if (message === "") {
                    $("#message-signup").html("");
                } else {
                    $("#message-signup").html("<div class='alert-" + tipo + " alert alert-dismissible' role='alert'>" + message + "</div>");
                }
            }
        },
        validacion = function () {
            celularvalidado = $("#signupform-celular").val().match(/^[3]\d{9}$/g) != null;
            correo_electronicovalidado = $("#signupform-correo_electronico").val().match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/i) != null && $("#signupform-correo_electronico").val() === $("#signupform-repite_correo_electronico").val();
            identificacionvalidada = $("#signupform-identificacion").val().match(/^((\d{8})|(\d{10})|(\d{11}))$/g) != null;
            if ($("#signupform-celular").val() === celularvalido && $("#signupform-identificacion").val() === identificacionvalida && $("#signupform-correo_electronico").val() === correo_electronicovalido) {
                celular = $("#signupform-celular").val();
                identificacion = $("#signupform-identificacion").val();
                correo_electronico = $("#signupform-correo_electronico").val();
                tokenobtenido = !0;
                listocelular();
            } else {
                todovalidado = (celularvalidado && correo_electronicovalidado && identificacionvalidada);
                if (todovalidado) {
                    setMessage('Dé clic en el botón [TOKEN] para recibir el token en su celular.', "info");
                }
                $("#obtener-token-button").prop('disabled', !(todovalidado));
                //$("#signupform-token").prop('readonly',!0); // Hay que activar este
                $("#signupform-token").val("");
                $("#signupform-token").attr("placeholder", 'Dé clic en el botón [TOKEN] para recibir el token en su celular.');
                tokenobtenido = false;
            }
        }
    ;
    $(".setup-content").each(function (index, element) {
        if (index > 0) {
            contentCargados.push(false);
        }
        $(this).data('index', index);
    });
    $("#signup-button").on("click", function (event) {
        $("#signupform-foto").val(foto64);
        $("#signupform-password").val("*Bs5+YSu$&-QBD(R");
        $("#signupform-password_repeat").val("*Bs5+YSu$&-QBD(R");
    });
    $("#signupform-password_fake,#signupform-password_repeat_fake").on("blur", function (event) {
        const len = $(this).attr("id").length - 5, fid = $(this).attr("id").slice(0, len),
            eid = "#signupform-enc_" + fid.slice(11), encrypt = new JSEncrypt();
        encrypt.setPublicKey(pk);
        const encrypted = encrypt.encrypt("#" + $(fid).val());
        $(eid).val(encrypted);
        console.log(eid + ": " + encrypted.length);
    });
    $("#foto-button").on('focusout', function (e) {
        _formsignup.yiiActiveForm("validateAttribute", "signupform-foto");
    });
    $("#signupform-captcha-image").trigger("click");
    $("#documentoidentificacion-button").on("click", function (e) {
        const btn = $('#signupform-documentoidentificacion');
        btn.click();
        return false;
    });
    $("#documentoidentificacion-button").on("focusout", function (e) {
        _formsignup.yiiActiveForm("validateAttribute", "signupform-documentoidentificacion");
    });
    $("#obtener-token-button").on("focusout", function (e) {
        if (!($('#signupform-token').is('[readonly]'))) {
            $('#signupform-token').focus();
        }
    });
    $("#signupform-documentoidentificacion").on("change", function (e) {
        const canvaspdf = $("#canvaspdf").get(0), pdffile = $(this).get(0).files[0], fileReader = new FileReader(),
            pdfjsLib = window['pdfjs-dist/build/pdf'], canvasContext = canvaspdf.getContext('2d'),
            pdffile_url = URL.createObjectURL(pdffile);
        canvasContext.clearRect(0, 0, canvas.width, canvas.height);
        canvaspdf.height = 0;
        canvaspdf.width = 0;
        $("#signupform-pdf_correcto").val(0);
        if (pdffile.type !== "application/pdf") {
            console.error(pdffile.name, " no es un archivo pdf.");
            return;
        }
        fileReader.onload = function () {
            pdfjsLib.GlobalWorkerOptions.workerSrc = '<?= $pdfJsAsset->baseUrl ?>/pdf.worker.js'; // '//mozilla.github.io/pdf.js/build/pdf.worker.js';
            const typedarray = new Uint8Array(this.result), loadingTask = pdfjsLib.getDocument(typedarray);
            loadingTask.promise.then(function (pdf) {
                pdf.getPage(pdf.numPages).then(function (page) {
                    const viewport = page.getViewport({'scale': 1, 'rotate': 0});
                    canvaspdf.height = viewport.height;
                    canvaspdf.width = viewport.width;
                    page.render({'canvasContext': canvasContext, 'viewport': viewport});
                    $("#signupform-pdf_correcto").val(1);
                    $("#viewerpdfconfirm").attr("src", pdffile_url);
                    $("#errorpdf").html("");
                    _formsignup.yiiActiveForm("validateAttribute", "signupform-documentoidentificacion");
                });
            }, function (reason) {
                console.error(reason);
                $("#errorpdf").html("<div class='alert-danger alert alert-dismissible' role='alert'>Debe cargar un pdf legible.</div>");
                $("#viewerpdfconfirm").attr('src', '');
                setMessage("El pdf que intenta cargar no tiene el formato correcto, está dañado o tiene contraseña. Debe usar otro archivo.", "danger");
            });
        };
        fileReader.readAsArrayBuffer(pdffile);
        _formsignup.yiiActiveForm("validateAttribute", "signupform-pdf_correcto");
    });
    $("#signupform-tipo_identificacion_id").parent().find('.select2').on("focusout", function (e) {
        setMessage("", "");
        $("#span_tipodocumentoidentificacion").html(abreviaturasidentificacion[$("#signupform-tipo_identificacion_id").val()]);
    });
    $(".nocopypaste").on('paste copy cut', function (e) {
        e.preventDefault();
    }).on("select", function () {
        this.selectionStart = this.selectionEnd;
    });
    $(".triminput").on("focusout", function (e) {
        setMessage("", "");
        $(this).val($.trim($(this).val()));
    });
    $("#signupform-celular,#signupform-identificacion,#signupform-correo_electronico,#signupform-repite_correo_electronico").on("keyup", function (e) {
        if ($("#signupform-celular").val() !== "" && $("#signupform-identificacion").val() !== "" && $("#signupform-correo_electronico").val() != "") {
            validacion();
        }
    });
    $(':input[type="number"]').on("keypress", function (e) {
        const event = e || window.event,
            keycode = ("keyCode" in event) ? event.keyCode : event.which;
        if (keycode === 187 || keycode === 43 || keycode === 101 || keycode === 44 || keycode === 45 || keycode === 46 || keycode === 39 || keycode === 222 || $(this).val().length >= $(this).attr('maxlength')) {
            event.preventDefault();
            return;
        }
    });
    $("#obtener-token-button").on("click", function (e) {
        celular = $("#signupform-celular").val();
        correo_electronico = $("#signupform-correo_electronico").val();
        identificacion = $("#signupform-identificacion").val();
        const data = {
            'Token[celular]': celular,
            'Token[correo_electronico]': correo_electronico,
            'Token[identificacion]': identificacion,
        };
        if (celular.match(/^[3]\d{9}$/g)) {
            $.ajax({
                url: urlsms,
                type: "post",
                data: data,
                cache: false,
                async: true,
                success: function (response) {
                    tokenobtenido = response.resultado;
                    setMessage(response.message, ((tokenobtenido) ? "success" : "danger"));
                    if (tokenobtenido) {
                        listocelular();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            }).done(function (msg) {
            }).fail(function (jqXHR, textStatus) {
            }).always(function () {
            });
        } else {
            $("#signupform-celular").blur();
        }
    });
    $("#signupform-tipo_identificacion_id").parent().find('.select2').prop('id', 'signupform-tipo_identificacion_select2');
    $("#signupform-tipo_identificacion_id").parent().find('.select2').addClass("focus");
    $(":input,#signupform-tipo_identificacion_select2").on('focusin', function (e) {
        $('[data-spanid]').each(function (index, element) {
            const span = $("#" + $(this).data("spanid"));
            if ($(this).hasClass("nombresaspirante")) {
                span.html($(this).val().toUpperCase());
            } else if ($(this).hasClass("correosaspirante")) {
                span.html($(this).val().toLowerCase());
            } else {
                span.html($(this).val());
            }
        });
        $(".helpli").removeClass("alert alert-info");
        $(".helpli").addClass("noshow");
        const help_li = "#help-for-" + $(this).attr("id");
        if ($(help_li).length > 0) {
            $(help_li).addClass("alert alert-info");
            $(help_li).removeClass("noshow");
        }
    });
    allWells.hide(); // hide all contents by default
    navListItems.on('click', function (e) {
        e.preventDefault();
        const _target = $($(this).attr('href')),
            _item = $(this),
            _focus = _target.find('.focus');
        if (!_item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            _item.addClass('btn-primary');
            allWells.hide();
            _target.show();
            if (_focus.is('select')) {
                $("#" + _focus.prop('id')).select2('open').select2('close').select2('open');
            } else {
                _focus.focus();
            }
        }
    });
    // next button
    $('.nextBtn').click(function () {
        // Validation
        $.each(_formsignup.data("yiiActiveForm").attributes, function () {
            if (!($("#" + this.id).closest(".form-group").hasClass("has-error"))) {
                this.status = 3;
            }
        });
        _formsignup.yiiActiveForm("validate");
        const curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            curStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]'),
            nextStepWizardStep = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next(),
            nextStepWizard = nextStepWizardStep.children("a"),
            curInputs = curStep.find(":input");
        let isValid = true;
        curInputs.each(function (index, element) {
            if ($(this).closest(".form-group").hasClass("has-error")) {
                isValid = false;
                return false;
            }
        });
        // move to next step if valid
        if (isValid) {
            curStepWizard.addClass("btn-success");
            nextStepWizardStep.removeClass('disabled');
            nextStepWizard.removeClass('disabled').trigger('click');
        }
    });
    // prev button
    $('.prevBtn').click(function () {
        const curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
        curStep.find("input[type='text'],input[type='email'],input[type='password'],input[type='url']");
        prevStepWizard.trigger('click');
    });
    $('div.setup-panel div a.btn-primary').trigger('click');
</script>
<?php JSRegister::end(); ?>
