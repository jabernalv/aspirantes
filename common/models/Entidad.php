<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "entidad".
 *
 * @property int $id Identificador
 * @property string $nombre Nombre
 * @property int $activo Es activo
 *
 * @property Proceso[] $procesos
 */
class Entidad extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'entidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
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
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'Identificador'),
            'nombre' => Yii::t('app', 'Nombre'),
            'activo' => Yii::t('app', 'Es activo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesos() {
        return $this->hasMany(Proceso::class, ['entidad_id' => 'id']);
    }

}
