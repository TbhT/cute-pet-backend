<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '宠物';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pet-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'petId',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status === 0 ? '正常' : '其他';
                }
            ],
            'nickname',
            'gender',
            [
                'attribute' => 'gender',
                'value' => function ($model) {
                    return $model->gender === 0 ? '公' : '母';
                }
            ],
            'age',
            [
                'attribute' => 'vaccineStatus',
                'value' => function ($model) {
                    return $model->vaccineStatus === 0 ? '未接种' : '已接种';
                }
            ],
            'color',
            'petType',
            'subType',
            'createTime',
            //'updateTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
