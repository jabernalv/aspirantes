<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cargo".
 *
 * @property int $id Identificador
 * @property int $proceso_id Proceso
 * @property string $nombre Cargo
 * @property string $created_at Fecha hora de creación
 * @property string $modified_at Fecha hora de actualización
 *
 * @property AspiranteCargo[] $aspiranteCargos
 * @property Proceso $proceso
 * @property OpcionCargo[] $opcionCargos 
 */
class Cargo extends \yii\db\ActiveRecord {

  /**
   * @var boolean $selected;
   */
  public $selected;

  /**
   * {@inheritdoc}
   */
  public static function tableName() {
    return 'cargo';
  }

  /**
   * {@inheritdoc}
   */
  public function rules() {
    return [
      [['proceso_id', 'nombre'], 'required'],
      [['proceso_id'], 'integer'],
      [['created_at', 'modified_at'], 'safe'],
      [['nombre'], 'string', 'max' => 255],
      [['proceso_id', 'nombre'], 'unique', 'targetAttribute' => ['proceso_id', 'nombre']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels() {
    return [
      'id' => Yii::t('app', 'Identificador'),
      'proceso_id' => Yii::t('app', 'Proceso'),
      'nombre' => Yii::t('app', 'Cargo'),
      'created_at' => Yii::t('app', 'Fecha hora de creación'),
      'modified_at' => Yii::t('app', 'Fecha hora de actualización'),
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getAspiranteCargos() {
    return $this->hasMany(AspiranteCargo::class, ['cargo_id' => 'id']);
  }

  /**
   * @return \yii\db\ActiveQuery 
   */
  public function getOpcionCargos() {
    return $this->hasMany(OpcionCargo::class, ['cargo_id' => 'id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getProceso() {
    return $this->hasOne(Proceso::class, ['id' => 'proceso_id']);
  }

}
