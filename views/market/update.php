<?php

use app\models\UploadForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Market */
/* @var $pictureForm app\models\UploadForm */

$this->title = '更新商家： ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '商家', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->marketId]];
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
<div class="market-update">

    <?= $this->render('_form', [
        'model' => $model,
        'pictureForm' => $pictureForm,
        'array' => $array,
        'button' => '更新'
    ]) ?>

</div>
