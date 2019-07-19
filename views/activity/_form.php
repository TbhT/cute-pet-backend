<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */
/* @var $form yii\widgets\ActiveForm */
/* @var $type */

$array = [];

if ($type === 2) {
    $array = [
        'initialPreview' => [
            $model->image
        ],
        'initialPreviewAsData' => true,
        'overwriteInitial' => false
    ];
}

?>

<div class="activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'beginTime')->widget('kartik\datetime\DateTimePicker', [
        'name' => 'beginTime',
        'value' => $model->beginTime,
        'readonly' => true,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:ss'
        ]
    ])
    ?>

    <?=
    $form->field($model, 'endTime')->widget('kartik\datetime\DateTimePicker', [
        'name' => 'endTime',
        'value' => $model->endTime,
        'readonly' => true,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:ss'
        ]
    ])
    ?>

    <?=
    $form->field($model, 'joinBeginTime')->widget('kartik\datetime\DateTimePicker', [
        'name' => 'joinBeginTime',
        'value' => $model->endTime,
        'readonly' => true,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:ss'
        ]
    ])
    ?>

    <?=
    $form->field($model, 'joinEndTime')->widget('kartik\datetime\DateTimePicker', [
        'name' => 'joinEndTime',
        'value' => $model->endTime,
        'readonly' => true,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:ss'
        ]
    ])
    ?>

    <?= $form->field($model, 'organizer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coorganizer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'image')->widget('kartik\file\FileInput', [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => $array,
    ])
    ?>


    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
