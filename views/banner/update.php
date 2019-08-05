<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */
/* @var $pictureForm app\models\UploadForm*/

$this->title = '更新轮播图 ：' . $model->bannerId;
$this->params['breadcrumbs'][] = ['label' => '轮播图', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bannerId, 'url' => ['view', 'id' => $model->bannerId]];
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
<div class="banner-update">


    <?= $this->render('_form', [
        'model' => $model,
        'pictureForm' => $pictureForm,
        'array' => $array,
        'button' => '更新'
    ]) ?>

</div>
