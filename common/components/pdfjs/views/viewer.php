<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\ActiveForm;

/* @var $id string */
/* @var $url string */
/* @var $buttons array */
/* @var $options array */

$url = Url::to(['/pdfjs', 'file' => Url::to($url)]);
$this->registerJs('
  $("#pdfjs-form-' . $id . '").submit();
  $("#pdfjs-' . $id . '").css("background-color","#404040");
');
$options = ArrayHelper::merge([
    'id' => 'pdfjs-' . $id,
    'name' => 'pdfjs-' . $id
], $options);
?>
<?php $form = ActiveForm::begin([
    'id' => 'pdfjs-form-' . $id,
    'options' => [
        'class' => 'form-horizontal',
        'target' => 'pdfjs-' . $id,
    ],
    'action' => $url
]) ?>
<?php foreach ($buttons as $btn => $value): ?>
    <?= $value == false ? Html::hiddenInput($btn, 0) : null; ?>
<?php endforeach; ?>
<?php ActiveForm::end() ?>
<?= Html::tag('iframe allowfullscreen webkitallowfullscreen', '', $options); ?>
