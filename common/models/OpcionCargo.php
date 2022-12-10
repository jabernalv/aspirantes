<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "opcion_cargo".
 *
 * @property int $id Identificador
 * @property int $cargo_id Cargo
 * @property string $opcion Opción
 * @property int $requiere_titulo Requiere título de grado
 * @property float $anios_experiencia_profesional Años experiencia profesional
 * @property float $anios_experiencia_relacionada Años experiencia relacionada
 * @property string $created_at Fecha hora de creación
 * @property string $modified_at Fecha hora de actualización
 *
 * @property AspiranteCargo[] $aspiranteCargos
 * @property Cargo $cargo
 */
class OpcionCargo extends \yii\db\ActiveRecord {

  /**
   * {@inheritdoc}
   */
  public static function tableName() {
    return 'opcion_cargo';
  }

  /**
   * {@inheritdoc}
   */
  public function rules() {
    return [
      [['cargo_id', 'opcion'], 'required'],
      [['cargo_id', 'requiere_titulo'], 'integer'],
      [['anios_experiencia_profesional', 'anios_experiencia_relacionada'], 'number'],
      [['created_at', 'modified_at'], 'safe'],
      [['opcion'], 'string', 'max' => 512],
      [['cargo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cargo::class, 'targetAttribute' => ['cargo_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels() {
    return [
      'id' => Yii::t('app', 'Identificador'),
      'cargo_id' => Yii::t('app', 'Cargo'),
      'opcion' => Yii::t('app', 'Opción'),
      'requiere_titulo' => Yii::t('app', 'Requiere título de grado'),
      'anios_experiencia_profesional' => Yii::t('app', 'Años experiencia profesional'),
      'anios_experiencia_relacionada' => Yii::t('app', 'Años experiencia relacionada'),
      'created_at' => Yii::t('app', 'Fecha hora de creación'),
      'modified_at' => Yii::t('app', 'Fecha hora de actualización'),
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getAspiranteCargos() {
    return $this->hasMany(AspiranteCargo::class, ['opcion_cargo_id' => 'id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getCargo() {
    return $this->hasOne(Cargo::class, ['id' => 'cargo_id']);
  }

}
