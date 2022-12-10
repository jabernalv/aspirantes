<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tipo_identificacion".
 *
 * @property int $id Identificador
 * @property string $nombre Tipo de identificador
 * @property string $abreviatura Abreviatura 
 * @property int $activo Activo o no
 *
 * @property Aspirante[] $aspirantes
 */
class TipoIdentificacion extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tipo_identificacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['nombre', 'abreviatura'], 'required'],
            [['activo'], 'integer'],
            [['nombre'], 'string', 'max' => 128],
            [['abreviatura'], 'string', 'max' => 3],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'Identificador'),
            'nombre' => Yii::t('app', 'Tipo de identificador'),
            'abreviatura' => Yii::t('app', 'Abreviatura'),
            'activo' => Yii::t('app', 'Activo o no'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAspirantes() {
        return $this->hasMany(Aspirante::class, ['tipo_identificacion_id' => 'id']);
    }

}
