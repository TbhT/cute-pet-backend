<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tweet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tweet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tweetId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'userId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commentCount')->textInput() ?>

    <?= $form->field($model, 'likeCount')->textInput() ?>

    <?= $form->field($model, 'createTime')->textInput() ?>

    <?= $form->field($model, 'updateTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
