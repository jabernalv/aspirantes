<?php

namespace frontend\models;

use Yii;
use common\models\Aspirante;
use yii\base\Model;

class ResendVerificationEmailForm extends Model {

    /**
     * @var string
     */
    public $correo_electronico;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['correo_electronico', 'trim'],
            ['correo_electronico', 'required'],
            ['correo_electronico', 'email'],
            ['correo_electronico', 'exist',
                'targetClass' => '\common\models\Aspirante',
                'filter' => ['status' => Aspirante::STATUS_INACTIVE],
                'message' => 'No hay un usuario con esta dirección de correo electrónico.'
            ],
        ];
    }

    /**
     * Sends confirmation email to user
     *
     * @return bool whether the email was sent
     */
    public function sendEmail() {
        $aspirante = Aspirante::findOne([
                    'correo_electronico' => $this->correo_electronico,
                    'status' => Aspirante::STATUS_INACTIVE
        ]);

        if ($aspirante === null) {
            return false;
        }

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
