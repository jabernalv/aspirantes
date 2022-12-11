<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\bootstrap5\Html;
use yii\helpers\Url;
?>
<?php if (Yii::$app->user->isGuest) : ?>
    <div class="row">
        <div class="col-md-7">
            <a href="#" class="showModalLinkImage">
                <img class="img-fluid rounded mb-3 mb-md-0" src="/img/faq02_aceptarcamara.png?<?= time() ?>" alt="Imagen de aceptar uso de cámara">
            </a>
            <a href="#" class="showModalLinkImage">
                <img class="img-fluid rounded mb-3 mb-md-0" src="/img/faq03_accesodenegadocamara.png?<?= time() ?>" alt="Imagen de acceso denegado a la  cámara">
            </a>
        </div>
        <div class="col">
            <h3>Acepte el acceso a la cámara</h3>
            <p>Debe aceptar que el sitio web haga uso de la cámara web.</p>
            <p>Si no tiene cámara web o no otorga el acceso a la cámara, no podrá registrarse en ese computador y aparecerá un mensaje de error como el siguiente:</p>
            <div class='alert-danger alert alert-dismissible' role='alert'>No se puede acceder a la camara, o no se ha dado permiso. Es necesario dar permiso de uso a la cámara para poder tomar la fotografía. El error reportado es: <i>Permission denied</i></div>
            <p>Debe buscar un computador que tenga cámara web u otorgar el acceso a la cámara del que tiene.</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-7">
            <a href="#" class="showModalLinkImage">
                <img class="img-fluid rounded mb-3 mb-md-0" src="/img/faq04_formularioregistro.png?<?= time() ?>" alt="Imagen del formulario de registro">
            </a>
        </div>
        <div class="col">
            <h3>Diligencie los datos de autenticación</h3>
            <p>Llene los datos solicitados en el formulario de registro. Al posicionarse en cada campo del formulario se resaltará en la parte izquierda un mensaje de ayuda.</p>
            <p>Por ejemplo, al posicionarse en el campo [Nombres] se resaltará la siguiente ayuda:</p>
            <div class="helpli alert alert-info" id="help-for-signupform-correo_electronico">
                Ingrese el correo electrónico.
                <ul>
                    <li>Debe ser un correo electrónico real y con formato válido.</li>
                    <li>Solo se permite que se registre una vez por cada buzón de correo.</li>
                    <li>No podrá ser cambiado más adelante, use un correo personal al cual pueda acceder siempre.</li>
                </ul>
            </div>
            <p>Seleccione el tipo de documento de identidad, ingrese el número de documento de identidad y el número de celular que se usará para validar el registro.</p>
            <ul>
                <li>El mismo número de celular solo se puede utilizar para registrar dos personas diferentes.</li>
                <li>Solo se permiten números de celular de Colombia.</li>
            </ul>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-7">
            <a href="#" class="showModalLinkImage">
                <img class="img-fluid rounded mb-3 mb-md-0" src="/img/faq05_formulariocontoken.png?<?= time() ?>" alt="Imagen de formulario de registro con foto">
            </a>
        </div>
        <div class="col">
            <h3>Ingrese el TOKEN</h3>
            <p>Cuando el sistema verifica que se introdujo un número de celular válido se activa el botón</p>
            <button type="button" class="btn btn-primary"><i class="icon-mobile"></i> Token</button>
            <p>Al dar clic en el botón recibirá un mensaje de texto SMS en el celular que ingresó, es un número de seis cifras que debe ser ingresado en el campo.</p>
            <div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><svg class="svg-inline--bi bi-sticky-fill fa-w-14" aria-hidden="true" data-prefix="fa" data-icon="sticky-note" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M312 320h136V56c0-13.3-10.7-24-24-24H24C10.7 32 0 42.7 0 56v400c0 13.3 10.7 24 24 24h264V344c0-13.2 10.8-24 24-24zm129 55l-98 98c-4.5 4.5-10.6 7-17 7h-6V352h128v6.1c0 6.3-2.5 12.4-7 16.9z"></path></svg><!-- <i class="bi bi-sticky-fill"></i> --></span></div><input type="number" id="signupform-token" class="form-control nocopypaste is-valid" name="SignupForm[token]" maxlength="6" step="1" min="100000" max="999999" placeholder="Dé clic en el botón [TOKEN] para recibir el token en su celular." autocomplete="nope" data-message="Ingrese el token enviado a su celular." tabindex="-1" aria-required="true" data-cip-id="signupform-token" aria-invalid="false"></div>
            <p>Ingrese el token que recibió en el celular y dé clic en el botón</p>
            <button class="btn btn-light btn-block nextBtnFake float-right" type="button">Siguiente <i class="bi bi-chevron-double-right"></i></button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-7">
            <a href="#" class="showModalLinkImage">
                <img class="img-fluid rounded mb-3 mb-md-0" src="/img/faq06_formulariocondatospersonales.png?<?= time() ?>" alt="Imagen de formulario de registro con foto">
            </a>
        </div>
        <div class="col">
            <h3>Ingrese sus datos personales</h3>
            <p>Ingrese nombres, apellidos y fecha de nacimiento. Tal y como aparecen el documento de identidad.</p>
            <p>Recuerde que se validarán estos datos contra el documento que cargue.</p>
            <p>Cuando termine dé clic en el botón</p>
            <button class="btn btn-light btn-block nextBtnFake float-right" type="button">Siguiente <i class="bi bi-chevron-double-right"></i></button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-7">
            <a href="#" class="showModalLinkImage">
                <img class="img-fluid rounded mb-3 mb-md-0" src="/img/faq07_formularioregistroconfoto.png?<?= time() ?>" alt="Imagen de formulario de registro con foto">
            </a>
        </div>
        <div class="col">
            <h3>Tome su fotografía</h3>
            <p>Mire hacia la cámara web del computador y dé clic en el botón</p>
            <button type="button" class="btn btn-primary"><svg class="svg-inline--fa fa-camera-retro fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="camera-retro" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M48 32C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48H48zm0 32h106c3.3 0 6 2.7 6 6v20c0 3.3-2.7 6-6 6H38c-3.3 0-6-2.7-6-6V80c0-8.8 7.2-16 16-16zm426 96H38c-3.3 0-6-2.7-6-6v-36c0-3.3 2.7-6 6-6h138l30.2-45.3c1.1-1.7 3-2.7 5-2.7H464c8.8 0 16 7.2 16 16v74c0 3.3-2.7 6-6 6zM256 424c-66.2 0-120-53.8-120-120s53.8-120 120-120 120 53.8 120 120-53.8 120-120 120zm0-208c-48.5 0-88 39.5-88 88s39.5 88 88 88 88-39.5 88-88-39.5-88-88-88zm-48 104c-8.8 0-16-7.2-16-16 0-35.3 28.7-64 64-64 8.8 0 16 7.2 16 16s-7.2 16-16 16c-17.6 0-32 14.4-32 32 0 8.8-7.2 16-16 16z"></path></svg><!-- <i class="fa fa-camera-retro"></i> --> Tomar foto</button>
            <p>Aparecerá en el formulario la imagen tomada.</p>
            <p>Tenga en cuenta que esta fotografía será usada para validar que en efecto la persona que diligencia el formulario es la que aparece en el documento de identidad.</p>
            <p>Puede tomar varias veces la foto hasta que esté satisfecho con el resultado. Una vez que la fotografía sea enviada al servidor no se podrá cambiar.</p>
            <p>Cuando termine dé clic en el botón</p>
            <button class="btn btn-light btn-block nextBtnFake float-right" type="button">Siguiente <i class="bi bi-chevron-double-right"></i></button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-7">
            <a href="#" class="showModalLinkImage">
                <img class="img-fluid rounded mb-3 mb-md-0" src="/img/faq06_formulariocondocumento.png?<?= time() ?>" alt="Imagen de formulario de registro con foto">
            </a>
        </div>
        <div class="col">
            <h3>Cargue el documento de identidad</h3>
            <p>Dé clic en el botón</p>
            <button type="button" class="btn btn-primary"><i class="icon-contact-businesscard"></i> Documento ID</button>
            <p>Tenga en cuenta que debe cargar un archivo en formato PDF, de máximo 1 MB de peso, que no tenga contraseña y que sea legible.</p>
            <p>Este archivo se usará para validar con la fotografía que se tomó en el paso anterior. Una vez que este archivo sea enviado al servidor no se podrá cambiar.</p>
            <p>Verifique que el documento sea visible y legible, si no lo puede ver bien no lo envíe. Consiga una copia de mejor resolución antes de enviar su solicitud de registro.</p>
            <p>Cuando termine dé clic en el botón</p>
            <button class="btn btn-light btn-block nextBtnFake float-right" type="button">Siguiente <i class="bi bi-chevron-double-right"></i></button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-7">
            <a href="#" class="showModalLinkImage">
                <img class="img-fluid rounded mb-3 mb-md-0" src="/img/faq07_formularioconpasswords.png?<?= time() ?>" alt="Imagen de formulario de registro con foto">
            </a>
        </div>
        <div class="col">
            <h3>Ingrese la contraseña</h3>
            <p>Ingrese dos veces, en los campos que el formulario solicita, la contraseña que va a usar</p>
            <p>Por razones de seguridad debe tener por lo menos 8 caracteres de largo, por lo menos una letra mayúscula, por lo menos una letra minúscula, por lo menos un número y por lo menos un caracter especial como estos (*%$#).</p>
            <p>Cuando termine dé clic en el botón</p>
            <button class="btn btn-light btn-block nextBtnFake float-right" type="button">Siguiente <i class="bi bi-chevron-double-right"></i></button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-7">
            <a href="#" class="showModalLinkImage">
                <img class="img-fluid rounded mb-3 mb-md-0" src="/img/faq09_confirmacion.png?<?= time() ?>" alt="Imagen de formulario de registro diligenciado">
            </a>
        </div>
        
        <div class="col">
            <h3>Confirme el registro</h3>
            <p>Tenga en cuenta que una vez enviado el formulario no podrá cambiar:<br><ul><li>Nombres.</li><li>Apellidos.</li><li>Correo electrónico</li><li>Fecha de nacimiento.</li><li>Fotografía.</li><li>Documento de identificación.</li><li>Número de celular registrado.</li></ul></p>
            <p>Si está por completo seguro de que desea enviar el formulario valide el captcha y dé clic en el botón</p>
            <button type="submit" class="btn btn-custom btn-light nextBtnFake btn-block float-right"><svg class="svg-inline--fa fa-user-check fa-w-20" aria-hidden="true" data-prefix="fa" data-icon="user-check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg=""><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4zm323-128.4l-27.8-28.1c-4.6-4.7-12.1-4.7-16.8-.1l-104.8 104-45.5-45.8c-4.6-4.7-12.1-4.7-16.8-.1l-28.1 27.9c-4.7 4.6-4.7 12.1-.1 16.8l81.7 82.3c4.6 4.7 12.1 4.7 16.8.1l141.3-140.2c4.6-4.7 4.7-12.2.1-16.8z"></path></svg><!-- <i class="fa fa-user-check"></i> --> Registro</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-7">
            <a href="#" class="showModalLinkImage">
                <img class="img-fluid rounded mb-3 mb-md-0" src="/img/registroexitoso.png?<?= time() ?>" alt="Imagen de confirmación de registro">
            </a>
        </div>
        <div class="col">
            <h3>Registro finalizado</h3>
            <p>Aparecerá un mensaje de registro exitoso, sin embargo todavía no se puede hacer uso del sistema.</p>
            <p>Será validado que el documento de identidad cargado corresponda con la fotografía tomada, que el celular y el correo electrónico existan.</p>
            <p>Una vez esto sea validado recibirá un mensaje de correo electrónico en su buzón que le indicará que el registro fue validado.</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-7">
            <a href="#" class="showModalLinkImage">
                <img class="img-fluid rounded mb-3 mb-md-0" src="/img/correoconfirmacion.png?<?= time() ?>" alt="Imagen de correo de confirmación de registro">
            </a>
        </div>
        <div class="col">
            <h3>Dé clic en el enlace enviado al correo</h3>
            <p>Recibirá un mensaje de correo electrónico con un enlace para finalizar el registro, dé clic en el enlace enviado. Si lo prefiere puede seleccionarlo y copiarlo en el navegador.</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-7">
            <a href="#" class="showModalLinkImage">
                <img class="img-fluid rounded mb-3 mb-md-0" src="/img/correoverificado.png?<?= time() ?>" alt="Imagen de correo de registro verificado">
            </a>
        </div>
        <div class="col">
            <h3>El registro ha finalizado</h3>
            <p>Podrá ver la información que cargó en el servidor y comenzar a agregar más archivos de soporte de experiencia y estudios.</p>
            <p>Recuerde que una vez registrado no podrá cambiar:<br><ul><li>Nombres.</li><li>Apellidos.</li><li>Correo electrónico</li><li>Fecha de nacimiento.</li><li>Fotografía.</li><li>Documento de identificación.</li><li>Número de celular registrado.</li></ul></p>
        </div>
    </div>
<?php endif; ?>

