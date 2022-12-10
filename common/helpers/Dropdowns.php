<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\TipoArchivoAspirante;
use common\models\TipoIdentificacion;
use common\models\EstadoAspiranteProceso;
use common\models\Cargo;

class Dropdowns {
  /**
   * Devuelve un arreglo para ser usado en dropdowns
   * 
   * @param type $modelo Nombre del modelo que se usará
   * @param string $id Identificador de la tabla
   * @param string $nombre Descripción que se debe mostrar en las opciones
   * @param string $orderBy Campo por el cual se deben ordenar las opciones
   * @return []
   */
  public static function dropdown($modelo, $id = null, $nombre = null, $orderBy = null) {
    if(is_null($orderBy)){
      $orderBy = 'id';
    }
    if(is_null($id)){
      $id = 'id';
    }
    if(is_null($nombre)){
      $nombre = 'nombre';
    }
    return ArrayHelper::map(
        TipoArchivoAspirante::find()->orderBy($orderBy)->asArray()->all(), 'id', 'nombre');
  }
  
  /**
   * Tipos de archivo
   * 
   * @return []
   */
  public static function tiposarchivo_aspirantedropdown() {
    return ArrayHelper::map(
        TipoArchivoAspirante::find()->where(['<>', 'id', '1'])->orderBy('nombre')->asArray()->all(), 'id', 'nombre');
  }
  
  /**
   * Tipos de identificación
   * 
   * @return []
   */
  public static function tiposidentificaciondropdown() {
    return ArrayHelper::map(
        TipoIdentificacion::find()->orderBy('nombre')->asArray()->all(), 'id', 'nombre');
  }
  
  /**
   * Agreviaturas de tipos de identificación
   * 
   * @return []
   */
  public static function tiposidentificacionabreviaturasdropdown() {
    return ArrayHelper::map(
        TipoIdentificacion::find()->orderBy('id')->asArray()->all(), 'id', 'abreviatura');
  }
  
  /**
   * Estados del aspirante
   * 
   * @return []
   */
  public static function estadosaspirantedropdown() {
    return ArrayHelper::map(
        EstadoAspiranteProceso::find()->orderBy('id')->asArray()->all(), 'id', 'nombre');
  }
  
  /**
   * Cargos asociados al proceso
   * 
   * @param type $proceso_id Identificador del proceso
   * @return []
   */
  public static function cargosxprocesoiddropdown($proceso_id) {
    return ArrayHelper::map(
        Cargo::find()->where(['proceso_id' => $proceso_id])->orderBy('id')->asArray()->all(), 'id', 'nombre');
  }

}
