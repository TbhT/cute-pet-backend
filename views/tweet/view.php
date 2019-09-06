<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tweet */

$this->title = $model->tweetId;
$this->params['breadcrumbs'][] = ['label' => '动态', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tweet-view">

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->tweetId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->tweetId], [
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
            'tweetId',
            'userId',
            [
                'attribute' => 'status',
                'value' => $model->status === 0 ? '正常' : '屏蔽'
            ],
            'text:ntext',
            'image',
            'commentCount',
            'likeCount',
            'createTime',
            'updateTime',
        ],
    ]) ?>

</div>
