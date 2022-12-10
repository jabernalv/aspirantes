<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aspirante_pass_historia".
 *
 * @property string $uuid Identificador
 * @property string $aspirante_uuid Aspirante
 * @property string $password_hash
 * @property string $created_at
 *
 * @property Aspirante $aspiranteUu
 */
class AspirantePassHistoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aspirante_pass_historia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'aspirante_uuid', 'password_hash'], 'required'],
            [['created_at'], 'safe'],
            [['uuid', 'aspirante_uuid'], 'string', 'max' => 36],
            [['password_hash'], 'string', 'max' => 255],
            [['uuid'], 'unique'],
            [['aspirante_uuid'], 'exist', 'skipOnError' => true, 'targetClass' => Aspirante::className(), 'targetAttribute' => ['aspirante_uuid' => 'uuid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uuid' => Yii::t('app', 'Identificador'),
            'aspirante_uuid' => Yii::t('app', 'Aspirante'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[AspiranteUu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAspiranteUu()
    {
        return $this->hasOne(Aspirante::className(), ['uuid' => 'aspirante_uuid']);
    }
}
