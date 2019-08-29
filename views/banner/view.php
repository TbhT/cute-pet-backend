<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */

$this->title = $model->bannerId;
$this->params['breadcrumbs'][] = ['label' => '轮播图', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="banner-view">

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->bannerId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->bannerId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'bannerId',
            'name',
            [
                'attribute' => 'image',
                'value' => $model->image,
                'format' => [
                    'image',
                    ['width' => 100, 'height' => 100]
                ]
            ],
            [
                'attribute' => 'status',
                'value' => $model->status == 1 ? '已审核' : '未审核'
            ],
            'createTime',
            'updateTime',
        ],
    ]) ?>

</div>
