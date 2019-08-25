<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */
/* @var $form yii\widgets\ActiveForm */
/* @var $pictureForm app\models\UploadForm */
/* @var $button string */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        [
            0 => '未审核',
            1 => '已审核'
        ]
    ) ?>

    <?= $form->field($pictureForm, 'imageFile')->widget('kartik\file\FileInput', [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => $array,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($button, ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
