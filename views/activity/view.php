<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '活动', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="activity-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->activityId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->activityId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除 该赛事/活动?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'activityId',
            [
                'attribute' => 'status',
                'value' => $model->status == 1 ? '已审核' : '未审核'
            ],
            [
                'attribute' => 'type',
                'value' => $model->type == 1 ? '赛事类' : '非赛事类'
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
                'attribute' => 'image',
                'value' => $model->image,
                'format' => [
                    'image',
                    ['width' => 100, 'height' => 100]
                ]
            ]
        ]
    ]) ?>

</div>
