<?php

namespace frontend\models;

use yii\base\InvalidArgumentException;
use yii\base\Model;
use common\models\Aspirante;
use Yii;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model {

    public $password;
    public $password_repeat;

    /**
     * @var \common\models\Aspirante
     */
    private $_aspirante;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('El token para recuperación de contraseña no debe estar vacío.');
        }
        $this->_aspirante = Aspirante::findByPasswordResetToken($token);
        if (!$this->_aspirante) {
            throw new InvalidArgumentException('El token para recuperación de contraseña es erróneo.');
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 8, 'max' => 16],
            [['password'], 'match', 'pattern' => '/^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/', 'message' => 'Por lo menos una mayúscula, una minúscula, un número y un caracter especial'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Las dos contraseñas no coinciden"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'password' => Yii::t('app', 'Contraseña'),
            'password_repeat' => Yii::t('app', 'Repite contraseña'),
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword() {
        $aspirante = $this->_aspirante;
        $aspirante->setPassword($this->password);
        $aspirante->removePasswordResetToken();

        return $aspirante->save(false);
    }

}
