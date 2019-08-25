<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Comment */

$this->title = $model->commentId;
$this->params['breadcrumbs'][] = ['label' => '评论', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->commentId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->commentId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确认删除这条评论?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'commentId',
            'tweetId',
            'userId',
            'status',
            'createTime',
            'updateTime',
        ],
    ]) ?>

</div>
