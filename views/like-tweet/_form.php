<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LikeTweet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="like-tweet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'likeId')->textInput() ?>

    <?= $form->field($model, 'tweetId')->textInput() ?>

    <?= $form->field($model, 'userId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'createTime')->textInput() ?>

    <?= $form->field($model, 'updateTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
