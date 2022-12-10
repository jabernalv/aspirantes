<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "estado_aspirante_proceso".
 *
 * @property int $id Identificador
 * @property int $proceso_id Proceso 
 * @property string $nombre
 * @property int $activo Activo o no
 *
 * @property AspiranteCargo[] $aspiranteCargos
 * @property Proceso $proceso 
 */
class EstadoAspiranteProceso extends \yii\db\ActiveRecord {

  /**
   * {@inheritdoc}
   */
  public static function tableName() {
    return 'estado_aspirante_proceso';
  }

  /**
   * {@inheritdoc}
   */
  public function rules() {
    return [
      [['proceso_id', 'nombre'], 'required'],
      [['proceso_id', 'activo'], 'integer'],
      [['nombre'], 'string', 'max' => 128],
      [['proceso_id', 'nombre'], 'unique', 'targetAttribute' => ['proceso_id', 'nombre']],
      [['proceso_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proceso::class, 'targetAttribute' => ['proceso_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels() {
    return [
      'id' => Yii::t('app', 'Identificador'),
      'proceso_id' => Yii::t('app', 'Proceso'),
      'nombre' => Yii::t('app', 'Nombre'),
      'activo' => Yii::t('app', 'Activo o no'),
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getAspiranteCargos() {
    return $this->hasMany(AspiranteCargo::class, ['estado_id' => 'id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getProceso() {
    return $this->hasOne(Proceso::class, ['id' => 'proceso_id']);
  }

}
