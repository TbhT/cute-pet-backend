<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LikeTweet */

$this->title = 'Update Like Tweet: ' . $model->likeId;
$this->params['breadcrumbs'][] = ['label' => 'Like Tweets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->likeId, 'url' => ['view', 'id' => $model->likeId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="like-tweet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
