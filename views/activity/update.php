<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */
/* @var $activityUserModel app\models\ActivityUser */
/* @var $pictureForm app\models\UploadForm */


$this->title = '更新活动' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '活动', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->activityId]];
$this->params['breadcrumbs'][] = '更新';

$array = [
    'initialPreview' => [
        $model->image
    ],
    'initialPreviewAsData' => true,
    'overwriteInitial' => true,
    'showUpload' => false,
    'showCaption' => false,
    'language' => 'zh',
    'browseLabel' => '上传图片',
    'removeLabel' => '清除'
];
?>
<div class="activity-update">

    <?php $form = ActiveForm::begin() ?>

    <?=
    $this->render('_basic_info', [
        'model' => $model,
        'form' => $form,
        'array' => $array,
        'pictureForm' => $pictureForm
    ])
    ?>

    <?=
    $this->render('_place', [
        'model' => $model,
        'form' => $form
    ])
    ?>

    <div class="form-group">
        <?= Html::submitButton('更新', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
