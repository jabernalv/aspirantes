<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Aspirante;

/**
 * Login form
 */
class LoginForm extends Model {

    public $correo_electronico;
    public $password;
    public $rememberMe = true;
    private $_aspirante;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            // username and password are both required
            [['correo_electronico', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'correo_electronico' => Yii::t('app', 'Correo electrónico'),
            'password' => Yii::t('app', 'Contraseña'),
            'rememberMe' => Yii::t('app', 'Recuérdame'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $aspirante = $this->getAspirante();
            if (!$aspirante || !$aspirante->validatePassword($this->password)) {
                $this->addError($attribute, 'Correo electrónico o contraseña incorrectos.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getAspirante(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return Aspirante|null
     */
    protected function getAspirante() {
        if ($this->_aspirante === null) {
            $this->_aspirante = Aspirante::findByEmail($this->correo_electronico);
        }

        return $this->_aspirante;
    }

}
