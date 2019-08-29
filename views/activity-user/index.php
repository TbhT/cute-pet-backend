<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActivityUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '报名';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-user-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
//            'userId',
//            'name',
//            'phone',
//            'relation',
            //'size',
            [
                'attribute' => 'userInfo',
                'label' => '用户手机号',
                'value' => function ($model) {
                    return $model->userInfo->mobile;
                }
            ],
            [
                'label' => '用户姓名',
                'value' => function ($model) {
                    return $model->userInfo->name;
                }
            ],
            [
                'label' => '活动名称',
                'value' => function ($model) {
                    return $model->activityInfo->name;
                }
            ],
            'createTime',
//            'updateTime',
            //'tag',
            //'type',
            //'amount',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
