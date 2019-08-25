<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pet */

$this->title = $model->petId;
$this->params['breadcrumbs'][] = ['label' => '宠物', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pet-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->petId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->petId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确认删除?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'petId',
            'status',
            'nickname',
            'gender',
            'age',
            'vaccineStatus',
            'petType',
            'createTime',
            'updateTime',
        ],
    ]) ?>

</div>
