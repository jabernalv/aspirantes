<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "archivo_aspirante".
 *
 * @property string $uuid Identificador
 * @property string $aspirante_uuid Aspirante
 * @property int $tipo_archivo_aspirante_id Tipo de archivo_aspirante
 * @property string $comentarios_aspirante Comentarios del aspirante
 * @property string $ruta_web Ruta del archivo
 * @property string $md5
 * @property string $created_at Fecha de creación
 * @property string $modified_at Fecha de modificación
 *
 * @property common\models\Aspirante $aspirante Aspirante al que le pertenece el archivo_aspirante
 * @property common\models\TipoArchivoAspirante $tipoArchivoAspirante
 * @property common\models\ArchivoAspiranteProceso[] $archivo_aspiranteProcesos 
 * @property common\models\Proceso[] $procesos Procesos activos y no activos en los cuaels está asignado el archivo_aspirante
 * @property common\models\Proceso[] $procesosActivos Procesos activos en los cuales está asignado el archivo_aspirante
 * @property boolean $seleccionado Indica si el archivo_aspirante está seleccionado en un proceso dado
 */
class ArchivoAspirante extends \yii\db\ActiveRecord {

    public $archivo;
    public $seleccionado;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'archivo_aspirante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['uuid', 'aspirante_uuid', 'ruta_web', 'md5'], 'required'],
            [['comentarios_aspirante'], 'required', 'message' => 'Ingrese una breve descripción del archivo.'],
            [['tipo_archivo_aspirante_id'], 'required', 'message' => 'Seleccione un tipo de archivo.'],
            [['tipo_archivo_aspirante_id'], 'integer'],
            [['created_at', 'modified_at'], 'safe'],
            [['uuid', 'aspirante_uuid'], 'string', 'max' => 36],
            [['ruta_web'], 'string', 'max' => 128],
            [['comentarios_aspirante'], 'string', 'max' => 255],
            [['md5'], 'string', 'max' => 32],
            [['aspirante_uuid', 'md5'], 'unique', 'targetAttribute' => ['aspirante_uuid', 'md5'], 'message' => 'Ya se ha cargado este archivo'],
            [['ruta_web'], 'unique'],
            [['uuid'], 'unique'],
            [['aspirante_uuid'], 'exist', 'skipOnError' => true, 'targetClass' => Aspirante::class, 'targetAttribute' => ['aspirante_uuid' => 'uuid']],
            [['tipo_archivo_aspirante_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoArchivoAspirante::class, 'targetAttribute' => ['tipo_archivo_aspirante_id' => 'id']],
            [['archivo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'uuid' => Yii::t('app', 'Identificador'),
            'aspirante_uuid' => Yii::t('app', 'Aspirante'),
            'tipo_archivo_aspirante_id' => Yii::t('app', 'Tipo de archivo'),
            'comentarios_aspirante' => Yii::t('app', 'Descripción'),
            'ruta_web' => Yii::t('app', 'Ruta del archivo'),
            'md5' => Yii::t('app', 'Md5'),
            'created_at' => Yii::t('app', 'Fecha de creación'),
            'archivo' => Yii::t('app', 'Archivo - Solo se permiten archivos en formato .pdf y sin contraseña'),
            'modified_at' => Yii::t('app', 'Fecha de modificación'),
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
    public function getTipoArchivoAspirante() {
        return $this->hasOne(TipoArchivoAspirante::class, ['id' => 'tipo_archivo_aspirante_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchivosAspiranteCargo() {
        return $this->hasMany(ArchivoAspiranteCargo::class, ['archivo_aspirante_uuid' => 'uuid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargos() {
        return Cargo::find()
                ->innerJoin('aspirante_cargo', 'aspirante_cargo.cargo_id=cargo.id')
                ->innerJoin('archivo_aspirante_cargo', 'archivo_aspirante_cargo.aspirante_cargo_uuid=aspirante_cargo.uuid')
                ->where(['archivo_aspirante_cargo.archivo_aspirante_uuid' => $this->uuid])
                ->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCargosActivos() {
        return Cargo::find()
                ->innerJoin('proceso', 'proceso.id=cargo.proceso_id')
                ->innerJoin('aspirante_cargo', 'aspirante_cargo.cargo_id=cargo.id')
                ->innerJoin('archivo_aspirante_cargo', 'archivo_aspirante_cargo.aspirante_cargo_uuid=aspirante_cargo.uuid')
                ->where(['archivo_aspirante_cargo.archivo_aspirante_uuid' => $this->uuid, 'proceso.activo' => true])
                ->all();
    }

    /**
     * Verifica si el archivo_aspirante está asociado al proceso cuyo id se pasa como parámetro
     * 
     * @param int $proceso_id
     * @return boolean
     */
    public function seleccionadoencargo($cargo_id) {
        return (ArchivoAspiranteCargo::find()->innerJoin('aspirante_cargo', 'aspirante_cargo.uuid=archivo_aspirante_cargo.aspirante_cargo_uuid')->where(['aspirante_cargo.cargo_id' => $cargo_id, 'archivo_aspirante_uuid' => $this->uuid])->count() > 0);
    }

}
