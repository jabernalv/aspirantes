<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model {

    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;
    public $phone;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            // name, email, subject and body are required
            [['name'], 'required', 'message' => 'El nombre completo es obligatorio'],
            [['email'], 'required', 'message' => 'El correo electrónico es obligatorio'],
            [['subject'], 'required', 'message' => 'El asunto del mensaje es obligatorio'],
            [['phone'], 'required', 'message' => 'El teléfono de contacto es obligatorio'],
            [['body', 'phone'], 'required', 'message' => 'El mensaje es obligatorio'],
            // email has to be a valid email address
            ['email', 'email'],
            ['phone', 'integer'],
            [['phone'], 'match', 'pattern' => '/^[+]{0,1}[0-9]{8,12}$/', 'message' => 'Ingrese un número de teléfono válido'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'name' => 'Nombre completo',
            'email' => 'Correo electrónico',
            'subject' => 'Asunto del mensaje',
            'body' => 'Mensaje',
            'phone' => 'Teléfono de contacto',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email) {
        return Yii::$app->mailer->compose()
                        ->setTo($email)
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                        ->setReplyTo([$this->email => $this->name])
                        ->setSubject('Correo enviado desde ' . Yii::$app->name . ' - ' . $this->subject)
                        ->setTextBody('Teléfono de contacto: ' . $this->phone . ' - ' . $this->body)
                        ->send();
    }

}
