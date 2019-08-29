<?php

use app\models\Activity;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '活动';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-index">

    <p>
        <?= Html::a('新建活动', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Activity::UN_REVIEWED === $model->status ? '待审核' : '已审核';
                }
            ],
            'name',
            'beginTime',
            'endTime',
            'joinBeginTime',
            'joinEndTime',
            'organizer',
            'coorganizer',
            'place',
            [
                'label' => '查看报名情况',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('查看报名情况', Url::to(['/activity-user/index', 'ActivityUserSearch[activityId]' => $model->activityId]));
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'header' => '活动操作'
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
