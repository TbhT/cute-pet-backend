<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Market */
/* @var $form yii\widgets\ActiveForm */
/* @var $pictureForm app\models\UploadForm */
/* @var $button string */
?>

<div class="market-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'status')->dropDownList(
        [
            1 => '未审核',
            2 => '已审核'
        ]
    );
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($pictureForm, 'imageFile')->widget(FileInput::className(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => $array,
    ])
    ?>

    <div class="form-group">
        <?= Html::submitButton($button, ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
