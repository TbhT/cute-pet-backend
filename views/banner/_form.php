<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->widget('kartik\file\FileInput', [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'initialPreview' => [
                $model->image
            ],
            'initialPreviewAsData' => true,
            'overwriteInitial' => false,
            'showUpload' => false,
            'showCaption' => false,
            'language' => 'zh',
            'browseLabel' => '上传图片',
            'removeLabel' => '清除'
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
