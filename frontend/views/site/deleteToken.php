<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Eliminar registro';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
    <div class="row">
        <div class="col-lg">
            <?= $form->field($model, 'confirmacion', ['options' => ['tag' => 'span',]])->checkbox(['checked' => false]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg">
            Si está seguro que desea eliminar el registro, marque la casilla de confirmación y dé clic en el siguiente botón:
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <?= Html::submitButton('Eliminar', ['class' => 'btn btn-primary', 'id' => 'submit-button', 'disabled' => 'disabled']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$js = <<< JS
submitbtn=$("#submit-button");
$("#deleteemailform-confirmacion").on("change", function(e){submitbtn.attr('disabled', !$(this).prop("checked"));});
JS;
$this->registerJs($js);
