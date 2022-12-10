<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tipo_archivo_aspirante".
 *
 * @property int $id Identificador
 * @property string $nombre Tipo de archivo aspirante
 * @property int $activo Activo o no
 *
 * @property ArchivoAspirante[] $archivosAspirante
 */
class TipoArchivoAspirante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_archivo_aspirante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['activo'], 'integer'],
            [['nombre'], 'string', 'max' => 128],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Identificador'),
            'nombre' => Yii::t('app', 'Tipo de archivo'),
            'activo' => Yii::t('app', 'Activo o no'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchivosAspirante()
    {
        return $this->hasMany(ArchivoAspirante::class, ['tipo_archivo_aspirante_id' => 'id']);
    }
}
