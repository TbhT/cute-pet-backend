<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */

$this->title = '更新活动' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '活动', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->activityId]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="activity-update">

    <?= $this->render('_form', [
        'model' => $model,
        'type' => 2
    ]) ?>

</div>
