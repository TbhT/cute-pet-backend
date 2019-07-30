<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '轮播图';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">

    <p>
        <?= Html::a('新建轮播图', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'bannerId',
            'image',
            'name',
            'createTime',
            'updateTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
