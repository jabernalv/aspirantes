<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Tomado y adaptado de https://code.tutsplus.com/es/tutorials/how-to-program-with-yii2-user-access-controls--cms-23173
 */

namespace common\components;

use common\models\Rol;

class AccessRule extends \yii\filters\AccessRule {

  /**
   * @inheritdoc
   */
  protected function matchRole($user) {
    if (empty($this->roles)) {
      return true;
    }
    $cat = '';
    foreach ($this->roles as $role) {
      $cat .= '['.$role.']';
      if ($role == '?') {
        if ($user->getIsGuest()) {
          //require 1 . ' - [$role=' . $role.'] - [rolvalor='.$user->identity->rolvalor . ']';
          return true;
        }
      } elseif ($role == Rol::ROLE_USUARIO) {
        if (!$user->getIsGuest()) {
          //require 2 . ' - [$role' . $role.'] - [rolvalor='.$user->identity->rolvalor . ']';
          return true;
        }
        // Check if the user is logged in, and the roles match
      } elseif (!$user->getIsGuest() && $role == $user->identity->rolvalor) {
        //require 3 . ' - [$role' . $role.'] - [rolvalor='.$user->identity->rolvalor . ']';
        return true;
      }
    }
    //require 4 . ' - [$role' . $role.'] - [rolvalor='.$user->identity->rolvalor . ']';
    return false;
  }
  
}
