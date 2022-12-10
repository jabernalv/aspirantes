<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "archivo_proceso".
 *
 * @property int $id Identificador
 * @property int $proceso_id Proceso
 * @property string $descripcion
 * @property string $ruta_web
 * @property string $md5
 * @property string $created_at
 * @property string $modified_at
 *
 * @property Proceso $proceso
 */
class ArchivoProceso extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'archivo_proceso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proceso_id', 'descripcion', 'ruta_web', 'md5'], 'required'],
            [['proceso_id'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['descripcion'], 'string', 'max' => 255],
            [['ruta_web'], 'string', 'max' => 128],
            [['md5'], 'string', 'max' => 32],
            [['ruta_web'], 'unique'],
            [['proceso_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proceso::className(), 'targetAttribute' => ['proceso_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Identificador'),
            'proceso_id' => Yii::t('app', 'Proceso'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'ruta_web' => Yii::t('app', 'Ruta Web'),
            'md5' => Yii::t('app', 'Md5'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProceso()
    {
        return $this->hasOne(Proceso::className(), ['id' => 'proceso_id']);
    }
}
