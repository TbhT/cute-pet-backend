<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */
/* @var $activityUserModel app\models\ActivityUser */

$this->title = '创建活动';
$this->params['breadcrumbs'][] = ['label' => '活动', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>

    <?=
    $this->render('_basic_info', [
        'model' => $model,
        'form' => $form
    ])
    ?>

    <?=
    $this->render('_place', [
        'model' => $model,
        'form' => $form
    ])
    ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
