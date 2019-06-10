<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Market */

$this->title = 'Update Market: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Markets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->marketId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="market-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
