<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MarketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商家';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="market-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('添加商家', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'marketId',
//            'userId',
            'status',
            'name',
            'contact',
            'phone',
            'createTime',
            'updateTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
