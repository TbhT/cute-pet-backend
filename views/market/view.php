<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Market */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '商家', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="market-view">

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->marketId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->marketId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除商家?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'status',
            'name',
            'contact',
            'phone',
            'place',
            [
                'attribute' => 'image',
                'value' => $model->image,
                'format' => [
                    'image',
                    ['width' => 100, 'height' => 100]
                ]
            ],
            'createTime',
            'updateTime',
        ],
    ]) ?>

</div>
