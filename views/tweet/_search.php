<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TweetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tweet-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'tweetId') ?>

    <?= $form->field($model, 'userId') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'text') ?>

    <?= $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'commentCount') ?>

    <?php // echo $form->field($model, 'likeCount') ?>

    <?php // echo $form->field($model, 'createTime') ?>

    <?php // echo $form->field($model, 'updateTime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
