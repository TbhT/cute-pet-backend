<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tweet */

$this->title = 'Update Tweet: ' . $model->tweetId;
$this->params['breadcrumbs'][] = ['label' => 'Tweets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tweetId, 'url' => ['view', 'id' => $model->tweetId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tweet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
