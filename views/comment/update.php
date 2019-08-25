<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Comment */

$this->title = '更新评论: ' . $model->commentId;
$this->params['breadcrumbs'][] = ['label' => '评论', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->commentId, 'url' => ['view', 'id' => $model->commentId]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
