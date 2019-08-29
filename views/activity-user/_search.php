<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ActivityUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userId') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'relation') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'activityId') ?>

    <?php // echo $form->field($model, 'createTime') ?>

    <?php // echo $form->field($model, 'updateTime') ?>

    <?php // echo $form->field($model, 'tag') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
