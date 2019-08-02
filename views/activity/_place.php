<?php

/** @var $areaModel app\models\AreaCode */


use app\models\AreaCode;
use yii\helpers\Html;
use yii\helpers\Url; ?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            活动地点
        </div>
    </div>

    <div class="panel-body">
        <?=
        $form->field($model, 'province')->dropDownList(
            AreaCode::getProvinceList(),
            [
                'prompt' => '请选择省份',
                'id' => 'provinceId'
            ]
        );
        ?>

        <?=
        Html::hiddenInput(
            'selectedCityId',
            $model->isNewRecord ? '' : $model->city,
            [
                'id' => 'selectedCityId'
            ])
        ?>

        <?=
        $form->field($model, 'city')->widget('\kartik\depdrop\DepDrop', [
            'options' => ['id' => 'cityId'],
            'pluginOptions' => [
                'depends' => ['provinceId'],
                'placeholder' => '请选择城市',
                'initialize' => $model->isNewRecord ? false : true,
                'url' => Url::to('/activity/cities'),
                'params' => ['selectedCityId']
            ]
        ])
        ?>

        <?=
        Html::hiddenInput(
            'selectedAreaId',
            $model->isNewRecord ? '' : $model->area,
            [
                'id' => 'selectedAreaId'
            ]
        )
        ?>

        <?=
        $form->field($model, 'area')->widget('\kartik\depdrop\DepDrop', [
            'options' => ['id' => 'areaId'],
            'pluginOptions' => [
                'depends' => ['provinceId', 'cityId'],
                'placeholder' => '请选择区',
                'initialize' => $model->isNewRecord ? false : true,
                'url' => Url::to('/activity/area'),
                'params' => ['selectedAreaId']
            ]
        ])
        ?>

        <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?>

    </div>
</div>

