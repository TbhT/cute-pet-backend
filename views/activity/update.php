<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */
/** @var $activityUserModel app\models\ActivityUserModel */


$this->title = '更新活动' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '活动', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->activityId]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="activity-update">

    <?php $form = ActiveForm::begin() ?>
    <?=
    $this->render('_activity', [
        'model' => $model,
        'form' => $form,
        'type' => 2
    ])
    ?>

    <?=
    $this->render('_activity_user', [
        'model' => $activityUserModel,
        'form' => $form
    ])
    ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

</div>
