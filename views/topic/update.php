<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Topic */

$this->title = '更新话题: ' . $model->topicId;
$this->params['breadcrumbs'][] = ['label' => '话题', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->topicId, 'url' => ['view', 'id' => $model->topicId]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="topic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
