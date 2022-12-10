<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "aspirante".
 *
 * @property string $uuid Identificador
 * @property string $nombres Nombres
 * @property string $apellidos Apellidos
 * @property string $correo_electronico Correo electrónico
 * @property string $password_hash Hash password
 * @property string $fecha_nacimiento Fecha de nacimiento
 * @property int $tipo_identificacion_id Tipo ID
 * @property string $identificacion Identificación
 * @property string $celular Número de celular
 * @property string $urlfoto URL foto
 * @property int $status Estado
 * @property string $created_at Fecha hora de creación
 * @property string $updated_at Fecha hora de modificación
 * @property string $ip_creacion IP de creación
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $delete_token
 * @property string $auth_key
 * 
 * @property string $nombrecompleto Nombre completo
 * @property ArchivoAspirante[] $archivosAspirante
 * @property TipoIdentificacion $tipoIdentificacion
 * @property AspiranteCargo[] $aspiranteCargos
 */
class Aspirante extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    /**
     *
     * @var string Nueva contraseña
     */
    public $newpassword;

    /**
     *
     * @var string Contraseña actual
     */
    public $curpassword;

    /**
     *
     * @var string Repite nueva contraseña
     */
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'aspirante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['uuid', 'nombres', 'apellidos', 'fecha_nacimiento', 'correo_electronico', 'tipo_identificacion_id', 'identificacion', 'celular', 'ip_creacion', 'urlfoto'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_at', 'updated_at'], 'string'],
            [['correo_electronico'], 'email'],
            [['correo_electronico', 'nombres', 'apellidos'], 'trim'],
            //[['correo_electronico'], 'unique'],
            [['uuid'], 'string', 'max' => 36],
            [['ip_creacion'], 'string', 'max' => 40],
            [['nombres', 'apellidos'], 'string', 'max' => 128],
            [['identificacion'], 'integer', 'min' => 1],
            [['celular'], 'match', 'pattern' => '/^[3]\d{9}$/'],
            [['uuid', 'urlfoto'], 'unique'],
            [['tipo_identificacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoIdentificacion::class, 'targetAttribute' => ['tipo_identificacion_id' => 'id']],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['curpassword', 'newpassword', 'password_repeat'], 'string', 'min' => 8, 'max' => 16],
            [['curpassword', 'newpassword', 'password_repeat'], 'required', 'on' => 'changepassword'],
            [['newpassword'], 'match', 'pattern' => '/^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/', 'message' => 'Por lo menos una mayúscula, una minúscula, un número y un caracter especial'],
            ['password_repeat', 'compare', 'compareAttribute' => 'newpassword', 'message' => "Las dos contraseñas no coinciden"],
            [['fecha_nacimiento'], 'date', 'format' => 'yyyy-MM-dd'],
            ['curpassword', 'validateCurpassword'],
            ['newpassword', 'validateNewpassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'uuid' => Yii::t('app', 'Identificador'),
            'nombres' => Yii::t('app', 'Nombres'),
            'nombre_completo' => Yii::t('app', 'Nombre completo'),
            'identificacion_completo' => Yii::t('app', 'Identificación'),
            'apellidos' => Yii::t('app', 'Apellidos'),
            'correo_electronico' => Yii::t('app', 'Correo electrónico'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha de nacimiento'),
            'tipo_identificacion_id' => Yii::t('app', 'Tipo ID'),
            'identificacion' => Yii::t('app', 'Identificación'),
            'cargo_id' => Yii::t('app', 'Cargo al que aspira'),
            'created_at' => Yii::t('app', 'Registro'),
            'updated_at' => Yii::t('app', 'Fecha hora de modificación'),
            'curpassword' => Yii::t('app', 'Contraseña actual'),
            'newpassword' => Yii::t('app', 'Nueva contraseña'),
            'password_repeat' => Yii::t('app', 'Repite nueva contraseña'),
            'urlfoto' => Yii::t('app', 'Fotografía'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($uuid) {
        return static::findOne(['uuid' => $uuid, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by correo_electronico
     *
     * @param string $correo_electronico
     * @return static|null
     */
    public static function findByEmail($correo_electronico) {
        return static::findOne(['correo_electronico' => $correo_electronico, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by identificacion
     *
     * @param string $identificacion
     * @return static|null
     */
    public static function findByIdentificacion($identificacion) {
        return static::findOne(['identificacion' => $identificacion, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by celular
     *
     * @param string $identificacion
     * @return static|null
     */
    public static function findByCelular($celular) {
        $retorno = static::findAll(['celular' => $celular, 'status' => self::STATUS_ACTIVE]);
        if (is_null($retorno)) {
            return [];
        } else {
            return $retorno;
        }
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
                    'verification_token' => $token,
                    'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByDeleteToken($token) {
        return static::findOne([
                    'delete_token' => $token,
                    'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Valida la contraseña actual.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateCurpassword($attribute, $params) {
        $aspirante = Yii::$app->user->identity;
        if (!($aspirante->validatePassword($this->$attribute))) {
            $this->addError($attribute, 'Contraseña incorrecta.');
        }
    }

    /**
     * Valida la nueva contraseña.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateNewpassword($attribute, $params) {
        $aspirante = Yii::$app->user->identity;
        if ($aspirante->validatePassword($this->$attribute)) {
            $this->addError($attribute, 'Nueva contraseña debe ser diferente.');
            return;
        }
        $passhistorias = AspirantePassHistoria::find()->where(['aspirante_uuid' => Yii::$app->user->identity->uuid])->orderBy(['created_at' => SORT_DESC])->limit(10)->all();
        foreach ($passhistorias as $passhistoria) {
            if (Yii::$app->security->validatePassword($this->$attribute, $passhistoria->password_hash)) {
                $this->addError($attribute, 'Esta contraseña ya fue usada.');
                break;
            }
        }
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken() {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateDeleteToken() {
        $this->delete_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery 
     */
    public function getTipoIdentificacion() {
        return $this->hasOne(TipoIdentificacion::class, ['id' => 'tipo_identificacion_id']);
    }

    /**
     * @return string 
     */
    public function getNombre_completo() {
        return $this->nombres . ' - ' . $this->apellidos;
    }

    /**
     * @return string 
     */
    public function getIdentificacion_completo() {
        return $this->tipoIdentificacion->nombre . ': ' . $this->identificacion;
    }

    /**
     * @return \yii\db\ActiveQuery 
     */
    public function getArchivosAspirante() {
        return $this->hasMany(ArchivoAspirante::class, ['aspirante_uuid' => 'uuid']);
    }

    /**
     * @return \yii\db\ActiveQuery 
     */
    public function getAspiranteCargos() {
        return $this->hasMany(AspiranteCargo::class, ['aspirante_uuid' => 'uuid']);
    }

}
