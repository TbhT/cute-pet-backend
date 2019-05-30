<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pet */

$this->title = 'Update Pet: ' . $model->petId;
$this->params['breadcrumbs'][] = ['label' => 'Pets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->petId, 'url' => ['view', 'id' => $model->petId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
