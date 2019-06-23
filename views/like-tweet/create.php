<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LikeTweet */

$this->title = 'Create Like Tweet';
$this->params['breadcrumbs'][] = ['label' => 'Like Tweets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="like-tweet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
