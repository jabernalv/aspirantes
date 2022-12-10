<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "archivo_aspirante_cargo".
 *
 * @property string $uuid Identificador
 * @property string $archivo_aspirante_uuid Archivo
 * @property string $aspirante_cargo_uuid Cargo
 * @property string $comentarios_aspirante
 * @property string|null $comentarios_analista
 * @property int $tenido_en_cuenta
 *
 * @property AspiranteCargo $aspiranteCargoUu
 * @property ArchivoAspirante $archivo_aspirante
 */
class ArchivoAspiranteCargo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'archivo_aspirante_cargo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'archivo_aspirante_uuid', 'aspirante_cargo_uuid', 'comentarios_aspirante'], 'required'],
            [['tenido_en_cuenta'], 'integer'],
            [['uuid', 'archivo_aspirante_uuid', 'aspirante_cargo_uuid'], 'string', 'max' => 36],
            [['comentarios_aspirante'], 'string', 'max' => 255],
            [['comentarios_analista'], 'string', 'max' => 256],
            [['archivo_aspirante_uuid', 'aspirante_cargo_uuid'], 'unique', 'targetAttribute' => ['archivo_aspirante_uuid', 'aspirante_cargo_uuid']],
            [['uuid'], 'unique'],
            [['aspirante_cargo_uuid'], 'exist', 'skipOnError' => true, 'targetClass' => AspiranteCargo::class, 'targetAttribute' => ['aspirante_cargo_uuid' => 'uuid']],
            [['archivo_aspirante_uuid'], 'exist', 'skipOnError' => true, 'targetClass' => ArchivoAspirante::class, 'targetAttribute' => ['archivo_aspirante_uuid' => 'uuid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uuid' => Yii::t('app', 'Identificador'),
            'archivo_aspirante_uuid' => Yii::t('app', 'ArchivoAspirante'),
            'aspirante_cargo_uuid' => Yii::t('app', 'Cargo'),
            'comentarios_aspirante' => Yii::t('app', 'Comentarios Aspirante'),
            'comentarios_analista' => Yii::t('app', 'Comentarios Analista'),
            'tenido_en_cuenta' => Yii::t('app', 'Tenido En Cuenta'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAspiranteCargo()
    {
        return $this->hasOne(AspiranteCargo::class, ['uuid' => 'aspirante_cargo_uuid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchivoAspirante()
    {
        return $this->hasOne(ArchivoAspirante::class, ['uuid' => 'archivo_aspirante_uuid']);
    }
}
