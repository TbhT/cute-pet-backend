<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'beginTime')->textInput() ?>

    <?= $form->field($model, 'endTime')->textInput() ?>

    <?= $form->field($model, 'joinBeginTime')->textInput() ?>

    <?= $form->field($model, 'joinEndTime')->textInput() ?>

    <?= $form->field($model, 'organizer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coorganizer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
