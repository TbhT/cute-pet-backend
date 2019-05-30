<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pet-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'petId') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'nickname') ?>

    <?= $form->field($model, 'gender') ?>

    <?= $form->field($model, 'age') ?>

    <?php // echo $form->field($model, 'vaccineStatus') ?>

    <?php // echo $form->field($model, 'petType') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'createTime') ?>

    <?php // echo $form->field($model, 'updateTime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
