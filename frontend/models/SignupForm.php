<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Aspirante;
use common\models\Token;
use yii\captcha\Captcha;

/**
 * Signup form
 */
class SignupForm extends Model {

    /**
     * @var string
     */
    public $nombres;
    
    public $nombres_repeat;

    /**
     * @var string
     */
    public $apellidos;

    /**
     * @var string
     */
    public $correo_electronico;

    /**
     * @var string
     */
    public $repite_correo_electronico;

    /**
     * @var string
     */
    public $fecha_nacimiento;

    /**
     *
     * @var int 
     */
    public $tipo_identificacion_id;

    /**
     *
     * @var string 
     */
    public $identificacion;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $password_repeat;

    /**
     *
     * @var string
     */
    public $enc_password;

    /**
     *
     * @var string
     */
    public $enc_password_repeat;

    /**
     *
     * @var string
     */
    public $celular;

    /**
     *
     * @var int
     */
    public $token;

    /**
     *
     * @var string
     */
    public $foto;

    /**
     *
     * @var string
     */
    public $documentoidentificacion;

    /**
     *
     * @var int
     */
    public $pdf_correcto;
    
    /**
     *
     * @var captcha
     */
    public $captcha;
    
    public $fotoconfirmada;
    public $documentoconfirmado;
    public $terminosaceptados;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['nombres', 'required', 'message' => 'Ingrese el nombre completo.'],
            ['apellidos', 'required', 'message' => 'Ingrese los apellidos.'],
            ['correo_electronico', 'required', 'message' => 'Ingrese el correo electrónico.'],
            ['correo_electronico', 'validateCorreo'],
            ['repite_correo_electronico', 'required', 'message' => 'Repita el correo electrónico.'],
            ['fecha_nacimiento', 'required', 'message' => 'Ingrese la fecha de nacimiento.'],
            ['tipo_identificacion_id', 'required', 'message' => 'Seleccione tipo de identificación.'],
            ['identificacion', 'required', 'message' => 'Ingrese la identificación.'],
            ['identificacion', 'validateIdentificacion'],
            ['celular', 'required', 'message' => 'Ingrese el número de celular.'],
            ['celular', 'validateCelular'],
            ['token', 'required', 'message' => 'Ingrese el token enviado al celular.'],
            ['token', 'validateToken'],
            ['password', 'required', 'message' => 'Ingrese la contraseña.'],
            ['password_repeat', 'required', 'message' => 'Repita la contraseña.'],
            ['foto', 'required', 'message' => 'Debe tomar la fotografía.'],
            ['captcha', 'required', 'message' => 'Ingrese el texto que se muestra.'],
            ['captcha', 'validateCaptcha'],
            ['documentoidentificacion', 'required', 'message' => 'Cargue el documento ID.'],
            [['documentoidentificacion'],
                'file', 'extensions' => 'pdf',
                'mimeTypes' => 'application/pdf',
                'wrongExtension' => 'Solo archivos .pdf.',
                'wrongMimeType' => 'Solo archivos .pdf.',
                'uploadRequired' => 'Cargue documento ID.',
                'maxSize' => '1024000',
                'tooBig' => 'El archivo que intenta cargar es demasiado pesado.'],
            [['nombres', 'apellidos', 'correo_electronico'], 'trim'],
            [['correo_electronico'], 'email', 'message' => 'Correo electrónico NO válido'],
            [['correo_electronico', 'repite_correo_electronico'], 'string', 'max' => 255],
            ['repite_correo_electronico', 'compare', 'compareAttribute' => 'correo_electronico', 'message' => "Los dos correos deben ser iguales"],
            //['correo_electronico', 'unique', 'targetClass' => '\common\models\Aspirante', 'message' => 'Este correo electrónico ya está registrado.'],
            [['identificacion'], 'match', 'pattern' => '/^((\d{8})|(\d{10})|(\d{11}))?$/'],
            [['celular'], 'match', 'pattern' => '/^[3]\d{9}$/'],
            [['token'], 'match', 'pattern' => '/^[1-9]\d{5}$/'],
            [['password', 'password_repeat'], 'string', 'min' => 8, 'max' => 16],
            [['password'], 'match', 'pattern' => '/^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/', 'message' => 'Por lo menos una mayúscula, una minúscula, un número y un caracter especial'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Las dos contraseñas no coinciden"],
            ['tipo_identificacion_id', 'integer'],
            [['pdf_correcto'], 'integer', 'min' => 1, 'tooSmall' => 'Formato erróneo.'],
            [['fecha_nacimiento'], 'date', 'format' => 'yyyy-MM-dd'],
            [['fecha_nacimiento'], 'validateUserBirthDate'],
            ['fotoconfirmada', 'required', 'requiredValue' => 1, 'message' => 'Confirme la foto'],
            ['documentoconfirmado', 'required', 'requiredValue' => 1, 'message' => 'Confirme el documento'],
            ['terminosaceptados', 'required', 'requiredValue' => 1, 'message' => 'Debe confirmar'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'uuid' => Yii::t('app', 'Identificador'),
            'nombres' => Yii::t('app', 'Nombres'),
            'apellidos' => Yii::t('app', 'Apellidos'),
            'correo_electronico' => Yii::t('app', 'Correo electrónico'),
            'repite_correo_electronico' => Yii::t('app', 'Repita el correo electrónico'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha de nacimiento'),
            'tipo_identificacion_id' => Yii::t('app', 'Tipo ID'),
            'identificacion' => Yii::t('app', 'Identificación'),
            'cargo_id' => Yii::t('app', 'Cargo al que aspira'),
            'created_at' => Yii::t('app', 'Fecha hora de creación'),
            'updated_at' => Yii::t('app', 'Fecha hora de modificación'),
            'password' => Yii::t('app', 'Contraseña'),
            'password_repeat' => Yii::t('app', 'Repita la contraseña'),
            'token' => Yii::t('app', 'Token enviado por SMS al celular'),
            'celular' => Yii::t('app', 'Número de celular'),
            'captcha' => Yii::t('app', 'Ingrese el siguiente texto'),
            'fotoconfirmada' => Yii::t('app', 'Confirmo fotografía es correcta'),
            'documentoconfirmado' => Yii::t('app', 'Veo el documento de manera correcta'),
            'terminosaceptados' => Yii::t('app', 'Confirmo que todo es correcto y acepto el envío de la información'),
        ];
    }

    /**
     * https://forum.yiiframework.com/t/yii2-captcha-doesn-t-work-with-form-ajax-validation/86057/2
     * verify with function validateCaptcha(),avoid bug with Yii2 captcha's validation.
     * 
     * @param type $attribute
     */
    public function validateCaptcha($attribute) {
        //Param:'captcha'，is name 'captcha' in actions() of controller；Yii::$app->controller，the controller that call this function
        $captcha_validate = new \yii\captcha\CaptchaAction('captcha', Yii::$app->controller);
        if ($this->$attribute) {
            $code = $captcha_validate->verifyCode;
            if ($this->$attribute != $code) {
                $this->addError($attribute, 'El código de verificación es incorrecto.');
            }
        }
    }

    public function validateToken($attribute, $params, $validator) {
        if (is_null(Token::findOne([
                            'celular' => $this->celular,
                            'correo_electronico' => $this->correo_electronico,
                            'identificacion' => $this->identificacion,
                            'validado' => 0,
                            'token' => $this->$attribute,
                ]))) {
            $this->addError($attribute, 'Token incorrecto');
        }
    }

    public function validateCorreo($attribute, $params, $validator) {
        $dominio = explode("@", $this->$attribute)[1];
        $error = "";
        if (in_array($dominio, Yii::$app->params['dominiosbloqueados'])) {
            $error = 'Correo electrónico no permitido.';
        }
        $aspirante = Aspirante::findByEmail($this->$attribute);
        if (!is_null($aspirante)) {
            $error = 'Correo electrónico ya registrado y verificado.';
        }
        $aspirante = Aspirante::findOne(['correo_electronico' => $this->$attribute, 'status' => Aspirante::STATUS_INACTIVE]);
        if (!is_null($aspirante)) {
            $error = 'Correo electrónico ya registrado pero sin verificar.';
        }
        if ($error != "") {
            $this->addError($attribute, $error);
        }
    }

    public function validateIdentificacion($attribute, $params, $validator) {
        $aspirante = Aspirante::findByIdentificacion($this->$attribute);
        if (!is_null($aspirante)) {
            $this->addError($attribute, 'Identificación ya registrada y verificada.');
        }
    }

    public function validateCelular($attribute, $params, $validator) {
        $numero_aspirantes = Aspirante::find()->where(['celular' => $this->$attribute])->count();
        if ($numero_aspirantes >= 2) {
            $this->addError($attribute, '# celular ya usado.');
        }
    }

    public function validateUserBirthDate($attribute, $params) {
        $date = new \DateTime();
        date_sub($date, date_interval_create_from_date_string('75 years'));
        $minAgeDate = date_format($date, 'Y-m-d');
        date_add($date, date_interval_create_from_date_string('60 years'));
        $maxAgeDate = date_format($date, 'Y-m-d');
        if ($this->$attribute < $minAgeDate) {
            $this->addError($attribute, 'La fecha de nacimiento no está dentro del rango.');
        } elseif ($this->$attribute > $maxAgeDate) {
            $this->addError($attribute, 'La fecha de nacimiento no está dentro del rango.');
        }
    }

    /**
     * Signs user up.
     * 
     * @param \common\models\Aspirante $aspirante
     * @return boolean whether the creating new account was successful and email was sent
     */
    public function signup(&$aspirante) {
        /* if (!$this->validate()) {
          return null;
          }/* */

        $aspirante->nombres = $this->nombres;
        $aspirante->apellidos = $this->apellidos;
        $aspirante->correo_electronico = $this->correo_electronico;
        $aspirante->fecha_nacimiento = $this->fecha_nacimiento;
        $aspirante->tipo_identificacion_id = $this->tipo_identificacion_id;
        $aspirante->identificacion = $this->identificacion;
        $aspirante->urlfoto = /*Yii::$app->params['rutaarchivosaspirantes'] .
                DIRECTORY_SEPARATOR .
                substr($aspirante->identificacion, 0, 3) .
                DIRECTORY_SEPARATOR .
                $aspirante->identificacion .
                DIRECTORY_SEPARATOR .
                */$aspirante->identificacion . '_' . Yii::$app->security->generateRandomString();
        $aspirante->celular = $this->celular;
        $aspirante->setPassword($this->password);
        $aspirante->ip_creacion = Yii::$app->request->userIP;
        $aspirante->generateAuthKey();
        $aspirante->generateEmailVerificationToken();
        $aspirante->generateDeleteToken();
        $aspirante->uuid = Yii::$app->session->get('nuevoaspiranteuuid');
        if ($aspirante->save()) {
            Yii::$app->session->remove('nuevoaspiranteuuid');
            return $this->sendEmail($aspirante);
        } else {
            Yii::$app->session->setFlash('error', print_r($aspirante->getErrors(), true));
            return false;
        }
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($aspirante) {
        return Yii::$app
                        ->mailer
                        ->compose(
                                ['html' => 'aspiranteCreado-html', 'text' => 'aspiranteCreado-text'],
                                ['aspirante' => $aspirante]
                        )
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                        ->setTo($this->correo_electronico)
                        ->setSubject('Cuenta registrada en ' . Yii::$app->name)
                        ->send();
    }

}
