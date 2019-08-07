<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pet */

$this->title = '更新宠物: ' . $model->petId;
$this->params['breadcrumbs'][] = ['label' => '宠物', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->petId, 'url' => ['view', 'id' => $model->petId]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="pet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
