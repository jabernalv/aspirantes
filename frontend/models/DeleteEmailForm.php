<?php

namespace frontend\models;

use Yii;
use common\models\Aspirante;
use yii\base\InvalidArgumentException;
use yii\base\Model;

class DeleteEmailForm extends Model {

    /**
     * @var string
     */
    public $token;
    
    /**
     *
     * @var common\models\Aspirante
     */
    public $aspirante;
    
    public $confirmacion;
    
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['confirmacion', 'required', 'requiredValue' => 1, 'message' => 'Debe confirmar.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'confirmacion' => Yii::t('app', 'Confirmación'),
        ];
    }

    /**
     * Creates a form model with given token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, array $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('El token de borrado de correo electrónico no puede ser una cadena vacía.');
        }
        $this->aspirante = Aspirante::findByDeleteToken($token);
        if (!$this->aspirante) {
            throw new InvalidArgumentException('No se pudo encontrar el token de borrado de correo electrónico que se intenta usar o ya fue utilizado.');
        }
        parent::__construct($config);
    }

    /**
     * Verify email
     *
     * @return Aspirante|null the saved model or null if saving fails
     */
    public function deleteEmail() {
        $this->aspirante->status = Aspirante::STATUS_ACTIVE;
        $this->aspirante->verification_token = null;
        $this->aspirante->delete_token = null;
        return $this->aspirante->save(false) ? $this->aspirante : null;
    }

}
