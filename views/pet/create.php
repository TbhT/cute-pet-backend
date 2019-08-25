<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pet */

$this->title = '添加宠物';
$this->params['breadcrumbs'][] = ['label' => '宠物', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
