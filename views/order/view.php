<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '订单', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->orderId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->orderId], [
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
            'orderId',
            'activityId',
            [
                'attribute' => 'status',
                'value' => $model->status == 1 ? '未支付' : '已支付'
            ],
            'userId',
            [
                'attribute' => 'totalFee',
                'value' => function ($model) {
                    return $model->totalFee / 100 . '元';
                }
            ],
//            'totalFee',
            'name',
            'createTime',
//            'updateTime',
        ],
    ]) ?>

</div>
