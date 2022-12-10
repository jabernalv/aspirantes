<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pin_proceso".
 *
 * @property string $uuid Identificador
 * @property int $proceso_id Proceso
 * @property string $pin Pin
 * @property int $usado Usado
 * @property string $created_at Fecha hora de creación
 * @property string $modified_at Fecha hora de actualización
 *
 * @property AspiranteCargo[] $aspiranteCargos
 * @property Proceso $proceso
 */
class PinProceso extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pin_proceso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'proceso_id', 'pin'], 'required'],
            [['proceso_id', 'usado'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['uuid', 'pin'], 'string', 'max' => 36],
            [['proceso_id', 'pin'], 'unique', 'targetAttribute' => ['proceso_id', 'pin']],
            [['uuid'], 'unique'],
            [['proceso_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proceso::className(), 'targetAttribute' => ['proceso_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uuid' => Yii::t('app', 'Identificador'),
            'proceso_id' => Yii::t('app', 'Proceso'),
            'pin' => Yii::t('app', 'Pin'),
            'usado' => Yii::t('app', 'Usado'),
            'created_at' => Yii::t('app', 'Fecha hora de creación'),
            'modified_at' => Yii::t('app', 'Fecha hora de actualización'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAspiranteCargos()
    {
        return $this->hasMany(AspiranteCargo::className(), ['pin_proceso_uuid' => 'uuid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProceso()
    {
        return $this->hasOne(Proceso::className(), ['id' => 'proceso_id']);
    }
}
