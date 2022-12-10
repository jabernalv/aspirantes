<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;

use yii\base\Exception;
use yii\base\Model;
use yii\base\Widget;
use yii\web\JqueryAsset;

/**
 * Description of PasswordTextBox
 *
 * @author jairo-bernal
 */
class PasswordTextBox extends Widget {

  public $model;
  public $attribute;
  public $htmlOptions = [];
  public $options;

  protected function hasModel() {
    return $this->model instanceof Model;
  }

  public function init() {
//parent::init();
    JqueryAsset::register($this->getView());
  }

  public function run() {
    if (!$this->hasModel()) {
      throw new Exception('Model must be set');
    }
    return $this->render('passtextbox', [
        'model' => $this->model,
        'attribute' => $this->attribute,
        'options' => $this->options,
    ]);
  }

}
