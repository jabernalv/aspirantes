<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "token".
 *
 * @property int $id
 * @property string $ip_creacion Dirección IP de creación del Token
 * @property string|null $ip_registro Dirección IP en el registro exitoso
 * @property string $celular
 * @property string $correo_electronico
 * @property string $identificacion
 * @property int $token Token
 * @property string $created_at Fecha hora de creación
 * @property string $modified_at Fecha hora de actualización
 * @property int $validado
 */
class Token extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ip_creacion', 'celular', 'correo_electronico', 'identificacion', 'token'], 'required'],
            [['token', 'validado'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['ip_creacion', 'ip_registro'], 'string', 'max' => 40],
            [['celular'], 'string', 'max' => 10],
            [['correo_electronico'], 'string', 'max' => 128],
            [['correo_electronico'], 'email'],
            [['celular'], 'match', 'pattern' => '/^[3]\d{9}$/'],
            [['token'], 'match', 'pattern' => '/^[1-9]\d{5}$/'],
            [['identificacion'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'ip' => Yii::t('app', 'Dirección IP'),
            'celular' => Yii::t('app', 'Celular'),
            'correo_electronico' => Yii::t('app', 'Correo Electronico'),
            'identificacion' => Yii::t('app', 'Identificacion'),
            'token' => Yii::t('app', 'Token'),
            'created_at' => Yii::t('app', 'Fecha hora de creación'),
            'modified_at' => Yii::t('app', 'Fecha hora de actualización'),
            'validado' => Yii::t('app', 'Validado'),
        ];
    }

}
