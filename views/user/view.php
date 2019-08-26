<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '用户', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->userId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->userId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'userId',
            'mobile',
            'avatar',
            'name',
            'nickname',
            'birth',
            'gender',
            'age',
            'city',
            'province',
            'address',
            'idCard',
            'high',
            'status',
            'password_hash',
            'auth_key',
            'createTime',
            'updateTime',
        ],
    ]) ?>

</div>
