<?php
/* @var $type number */

if ($type === 2) {
    $array = [
        'initialPreview' => [
            $model->image
        ],
        'initialPreviewAsData' => true,
        'overwriteInitial' => false,
        'showUpload' => false,
        'showCaption' => false,
        'language' => 'zh',
        'browseLabel' => '上传图片',
        'removeLabel' => '清除'
    ];
} else {
    $array = [
        'removeLabel' => '清除',
        'language' => 'zh',
        'overwriteInitial' => false,
        'showUpload' => false,
        'showCaption' => false,
    ];
}

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
        $form->field($model, 'province')->dropDownList(
            [],
            [
                'prompt' => '请选择省份',
                'id' => 'me-activity-province'
            ]
        );
        ?>

        <?=
        $form->field($model, 'city')->dropDownList(
            [],
            [
                'prompt' => '请选择城市',
                'id' => 'me-activity-city'
            ]
        );
        ?>

        <?=
        $form->field($model, 'area')->dropDownList(
            [],
            [
                'prompt' => '请输入市区',
                'id' => 'me-activity-area'
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

        <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?>

        <?=
        $form->field($model, 'image')->widget('kartik\file\FileInput', [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => $array,
        ])
        ?>
    </div>
</div>

