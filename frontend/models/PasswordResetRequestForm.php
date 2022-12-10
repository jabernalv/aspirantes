<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Aspirante;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model {

    public $correo_electronico;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['correo_electronico', 'trim'],
            ['correo_electronico', 'required', 'message' => 'El correo electrónico es obligatorio'],
            ['correo_electronico', 'email', 'message' => 'Debe ingresar una dirección de correo electrónica válida'],
            ['correo_electronico', 'exist',
                'targetClass' => '\common\models\Aspirante',
                'filter' => ['status' => Aspirante::STATUS_ACTIVE],
                'message' => 'No hay un registro con esa dirección de correo electrónico.'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'correo_electronico' => Yii::t('app', 'Correo electrónico'),
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail() {
        /* @var $aspirante Aspirante */
        $aspirante = Aspirante::findOne([
                    'status' => Aspirante::STATUS_ACTIVE,
                    'correo_electronico' => $this->correo_electronico,
        ]);

        if (!$aspirante) {
            return false;
        }

        if (!Aspirante::isPasswordResetTokenValid($aspirante->password_reset_token)) {
            $aspirante->generatePasswordResetToken();
            if (!$aspirante->save()) {
                return false;
            }
        }

        return Yii::$app
                        ->mailer
                        ->compose(
                                ['html' => 'aspirantePasswordResetToken-html', 'text' => 'aspirantePasswordResetToken-text'],
                                ['aspirante' => $aspirante]
                        )
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                        ->setTo($this->correo_electronico)
                        ->setSubject('Recuperación de contraseña para ' . Yii::$app->name)
                        ->send();
    }

}
