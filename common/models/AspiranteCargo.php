<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "aspirante_cargo".
 *
 * @property string $uuid Identificador
 * @property string $aspirante_uuid Aspirante
 * @property int $cargo_id Cargo
 * @property int $opcion_cargo_id Opción 
 * @property string|null $pin_proceso_uuid Pin
 * @property int $estado_id Estado
 * @property string $created_at Fecha hora de creación
 * @property string $modified_at Fecha hora de actualización
 *
 * @property \common\models\Aspirante $aspirante
 * @property \common\models\Cargo $cargo
 * @property \common\models\Proceso $proceso
 * @property \common\models\Entidad $entidad
 * @property \common\models\EstadoAspiranteProceso $estado
 * @property \common\models\OpcionCargo $opcionCargo 
 * @property \common\models\PinProceso $pinProceso
 * @property \common\models\ArchivoAspiranteCargo[] $archivo_aspiranteCargos
 * @property \common\models\ArchivoAspirante[] $archivo_aspirantes
 * @property int $numero_archivo_aspirantes Número de archivo_aspirantes seleccionados para la aplicación al cargo
 * @property string $archivo_aspirantes_seleccionados Identificadores de los archivo_aspirantes seleccionados
 */
class AspiranteCargo extends \yii\db\ActiveRecord {

    public $numero_archivo_aspirantes = 0;
    public $archivo_aspirantes_seleccionados;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'aspirante_cargo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['uuid', 'aspirante_uuid', 'cargo_id', 'opcion_cargo_id', 'estado_id'], 'required'],
            [['cargo_id'], 'required', 'message' => 'Debe seleccionar uno de los cargos de este proceso.'],
            [['opcion_cargo_id'], 'required', 'message' => 'Debe escoger una de las opciones del cargo seleccionado.'],
            [['cargo_id', 'opcion_cargo_id', 'estado_id'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['uuid', 'aspirante_uuid', 'pin_proceso_uuid'], 'string', 'max' => 36],
            [['uuid'], 'unique'],
            [['numero_archivo_aspirantes'], 'integer', 'min' => 1, 'tooSmall' => 'Debe seleccionar por lo menos un documento para adjuntarlo a este proceso.'],
            [['aspirante_uuid'], 'exist', 'skipOnError' => true, 'targetClass' => Aspirante::class, 'targetAttribute' => ['aspirante_uuid' => 'uuid']],
            [['cargo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cargo::class, 'targetAttribute' => ['cargo_id' => 'id']],
            [['estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoAspiranteProceso::class, 'targetAttribute' => ['estado_id' => 'id']],
            [['opcion_cargo_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpcionCargo::class, 'targetAttribute' => ['opcion_cargo_id' => 'id']],
            [['pin_proceso_uuid'], 'exist', 'skipOnError' => true, 'targetClass' => PinProceso::class, 'targetAttribute' => ['pin_proceso_uuid' => 'uuid']],
            [['pin_proceso_uuid'], 'required',
                'when' => function ($model, $attribute) {
                    return ($model->proceso->requiere_pin && $model->$attribute == '');
                },
                'whenClient' => 'function(attribute, value){return ($("#requiere_pin").val() == 1 && value === "");}',
                'message' => 'Debe ingresar el pin que obtuvo para aplicar a este proceso'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'uuid' => Yii::t('app', 'Identificador'),
            'aspirante_uuid' => Yii::t('app', 'Aspirante'),
            'cargo_id' => Yii::t('app', 'Cargo'),
            'opcion_cargo_id' => Yii::t('app', 'Opción'),
            'estado_id' => Yii::t('app', 'Estado'),
            'created_at' => Yii::t('app', 'Fecha y hora'),
            'modified_at' => Yii::t('app', 'Fecha hora de actualización'),
            'cargo' => Yii::t('app', 'Cargo'),
            'proceso' => Yii::t('app', 'Proceso'),
            'entidad' => Yii::t('app', 'Entidad'),
            'estado' => Yii::t('app', 'Estado'),
            'aspirante' => Yii::t('app', 'Aspirante'),
            'pin_proceso_uuid' => Yii::t('app', 'Este proceso requiere que el aspirante adquiera un Pin para aplicar'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAspirante() {
        return $this->hasOne(Aspirante::class, ['uuid' => 'aspirante_uuid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProceso() {
        return $this->cargo->proceso;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntidad() {
        return $this->cargo->proceso->entidad;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargo() {
        return $this->hasOne(Cargo::class, ['id' => 'cargo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado() {
        return $this->hasOne(EstadoAspiranteProceso::class, ['id' => 'estado_id']);
    }

    /**
     * @return \yii\db\ActiveQuery 
     */
    public function getOpcionCargo() {
        return $this->hasOne(OpcionCargo::class, ['id' => 'opcion_cargo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPinProceso() {
        return $this->hasOne(PinProceso::class, ['uuid' => 'pin_proceso_uuid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchivoAspiranteCargos() {
        return $this->hasMany(ArchivoAspiranteCargo::class, ['aspirante_cargo_uuid' => 'uuid']);
    }

    /**
     * @return \yii\db\ActiveQuery 
     */
    public function getArchivoAspirantes() {
        return $this->hasMany(ArchivoAspirante::class, ['uuid' => 'archivo_aspirante_uuid'])->viaTable('archivo_aspirante_cargo', ['aspirante_cargo_uuid' => 'uuid']);
    }

}
