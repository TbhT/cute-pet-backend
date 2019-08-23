<?php

use kartik\file\FileInput;

/* @var $pictureForm app\models\UploadForm */

?>
<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            活动信息
        </div>
    </div>

    <div class="panel-body">
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

        <?=
        $form->field($model, 'status')->dropDownList(
            [
                0 => '未审核',
                1 => '已审核'
            ]
        );
        ?>

        <?=
        $form->field($model, 'type')->dropDownList(
            [
                0 => '非赛事类',
                1 => '赛事类'
            ]
        )
        ?>

        <?=
        $form->field($model, 'personUnitPrice')->textInput(['maxlength' => true])
        ?>

        <?=
        $form->field($model, 'petUnitPrice')->textInput(['maxlength' => true])
        ?>

        <?= $form->field($model, 'organizer')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'coorganizer')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'personCount')->textInput() ?>

        <?=
        $form->field($pictureForm, 'imageFile')->widget(FileInput::className(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => $array,
        ])
        ?>
    </div>
</div>
