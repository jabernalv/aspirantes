<?php

use yii\helpers\Html;

/* @var $model yii\base\Model */
/* @var $placeholder String */
/* @var $attribute String */
$modelreflect = new ReflectionClass($model);
$options['id'] = strtolower($modelreflect->getShortName()) . '-' . $attribute . '_fake';
$options['class'] = 'form-control round' . ((array_key_exists('class', $options)) ? ' ' . $options['class'] : '');
$options['autocomplete'] = 'new-password';
$options['aria-required'] = 'true';
$options['aria-invalid'] = 'true';
$options['width'] = 'max';
?>
<?php echo Html::textInput($attribute . '_fake', '', $options); ?>
<?php echo Html::textInput($modelreflect->getShortName() . '[' . $attribute . ']', '', ['id' => strtolower($modelreflect->getShortName()) . '-' . $attribute, 'style' => 'opacity:0;width:0px;height:0px;font-size:1px;display:none;',]); ?>
<?php
$script = '$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '_fake").focusout(function(e){$(this).closest("form").yiiActiveForm("validateAttribute","' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '");});$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '").focus(function(e){$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '_fake").focus();});$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '_fake").val($("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '").val().replace(/(.)/g,"•"));' .
  '$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '_fake").on("input",function(e){var ss=this.selectionStart-1;var ssv=ss||0;var char=this.value.substr(ssv,1);var x=char.charCodeAt(0);var y=String.fromCharCode(x);var p=$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '").val();if($("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '_fake").val().length<=$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '").val().length){$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '").val(p.substring(0,$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '_fake").val().length));}else if(y.match(/[a-zA-Z0-9!-@Ññ¡¿#$^_:,.·~\\\\]/)){$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '").val($("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '").val()+y);$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '_fake").val($("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '").val().replace(/(.)/g,"•"));}});' .
  '$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '_fake").on("paste",function(e){e.preventDefault();return false;});$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '_fake").on("copy",function(e){e.preventDefault();return false;});$("#' . strtolower($modelreflect->getShortName()) . '-' . $attribute . '_fake").on("cut",function(e){e.preventDefault();return false;});';
$this->registerJs($script);