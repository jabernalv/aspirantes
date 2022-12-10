<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "proceso".
 *
 * @property int $id Identificador
 * @property int $entidad_id Entidad
 * @property string $nombre Proceso
 * @property string|null $fecha_inicio Fecha de inicio
 * @property string|null $fecha_fin_aplicacion Fin cargue documentos
 * @property int $activo Activo o no
 * @property int $requiere_pin Requiere pin 
 * @property string $created_at Fecha de creación 
 * @property string $modified_at Fecha de modificación
 *
 * @property \common\models\Cargo[] $cargos 
 * @property \common\models\EstadoAspiranteProceso[] $estadoAspiranteProcesos
 * @property \common\models\PinProceso[] $pinesProceso 
 * @property \common\models\Entidad $entidad
 * @property \common\models\ArchivoProceso[] $archivosProceso
 */
class Proceso extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'proceso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['entidad_id', 'nombre'], 'required'],
            [['entidad_id', 'activo', 'requiere_pin'], 'integer'],
            [['fecha_inicio', 'fecha_fin_aplicacion', 'created_at', 'modified_at'], 'safe'],
            [['nombre'], 'string', 'max' => 128],
            [['entidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entidad::class, 'targetAttribute' => ['entidad_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'Identificador'),
            'entidad_id' => Yii::t('app', 'Entidad'),
            'nombre' => Yii::t('app', 'Proceso'),
            'fecha_inicio' => Yii::t('app', 'Fecha de inicio'),
            'fecha_fin_aplicacion' => Yii::t('app', 'Fin cargue documentos'),
            'activo' => Yii::t('app', 'Activo o no'),
            'requiere_pin' => Yii::t('app', 'Requiere pin'),
            'created_at' => Yii::t('app', 'Fecha de creación'),
            'modified_at' => Yii::t('app', 'Fecha de modificación'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery 
     */
    public function getCargos() {
        return $this->hasMany(Cargo::class, ['proceso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoAspiranteProcesos() {
        return $this->hasMany(EstadoAspiranteProceso::class, ['proceso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPinesProceso() {
        return $this->hasMany(PinProceso::class, ['proceso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntidad() {
        return $this->hasOne(Entidad::class, ['id' => 'entidad_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchivosProceso() {
        return $this->hasMany(ArchivoProceso::class, ['proceso_id' => 'id']);
    }

}
