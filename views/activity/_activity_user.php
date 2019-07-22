<?php

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

$model->tag = ['name', 'mobile', 'gender'];

?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            其他信息
        </div>
    </div>

    <div class="panel-body">
        <div class="panel-body">

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

            <?=
            $form->field($model, 'type')->dropDownList(
                [
                    1 => '两人一宠',
                    2 => '两人两宠',
                    3 => '一人两宠',
                    4 => '一人一宠'
                ],
                [
                    'prompt' => '选择支付类型'
                ]
            )
            ?>

            <?=
            $form->field($model, 'amount')->textInput();
            ?>

        </div>
    </div>
</div>
