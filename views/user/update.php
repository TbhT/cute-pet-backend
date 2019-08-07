<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = '更新用户 : ' . $model->userId;
$this->params['breadcrumbs'][] = ['label' => '用户', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->userId]];
$this->params['breadcrumbs'][] = '更新';
?>

<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
