<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tweet */

$this->title = '更新动态' . $model->tweetId;
$this->params['breadcrumbs'][] = ['label' => '动态', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tweetId, 'url' => ['view', 'id' => $model->tweetId]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="tweet-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
