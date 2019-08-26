<?php

use kartik\file\FileInput;

/* @var $pictureForm app\models\UploadForm */

$data = [
    'mobile' => '手机号',
    'name' => '姓名',
    'birth' => '生日',
    'gender' => '性别',
    'age' => '年龄',
    'city' => '城市',
    'province' => '省份',
    'address' => '地址',
    'idCard' => '身份证号',
    'high' => '身高'
];

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

        <?=
        $form->field($model, 'tag')->widget('kartik\select2\Select2', [
            'name' => 'tag',
            'data' => $data,
            'maintainOrder' => true,
            'options' => [
                'placeholder' => '选择必填项',
                'multiple' => true
            ],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ]
        ])
        ?>

    </div>
</div>
