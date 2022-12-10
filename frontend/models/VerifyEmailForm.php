<?php

namespace frontend\models;

use common\models\Aspirante;
use yii\base\InvalidArgumentException;
use yii\base\Model;

class VerifyEmailForm extends Model {

    /**
     * @var string
     */
    public $token;
    
    /**
     *
     * @var common\models\Aspirante
     */
    private $_aspirante;

    /**
     * Creates a form model with given token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, array $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('El token de verificación del correo electrónico no puede ser una cadena vacía.');
        }
        $this->_aspirante = Aspirante::findByVerificationToken($token);
        if (!$this->_aspirante) {
            throw new InvalidArgumentException('No se pudo encontrar el token de verificación de correo electrónico que se intenta usar o ya fue verificado.');
        }
        parent::__construct($config);
    }

    /**
     * Verify email
     *
     * @return Aspirante|null the saved model or null if saving fails
     */
    public function verifyEmail() {
        $aspirante = $this->_aspirante;
        $aspirante->status = Aspirante::STATUS_ACTIVE;
        $aspirante->verification_token = null;
        $aspirante->delete_token = null;
        return $aspirante->save(false) ? $aspirante : null;
    }

}
