<?php

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
                1 => '未审核',
                2 => '已审核'
            ]
        );
        ?>

        <?=
        $form->field($model, 'personUnitPrice')->textInput(['maxlength' => true])
        ?>

        <?=
        $form->field($model, 'petUnitPrice')->textInput(['maxlength' => true])
        ?>

        <?= $form->field($model, 'organizer')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'coorganizer')->textInput(['maxlength' => true]) ?>

        <?=
        $form->field($model, 'image')->widget('kartik\file\FileInput', [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [],
        ])
        ?>
    </div>
</div>
