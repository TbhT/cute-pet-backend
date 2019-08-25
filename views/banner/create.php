<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */
/* @var $pictureForm app\models\UploadForm UploadForm */

$this->title = '新建轮播图';
$this->params['breadcrumbs'][] = ['label' => '轮播图', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$array = [
    'removeLabel' => '清除',
    'language' => 'zh',
    'overwriteInitial' => false,
    'showUpload' => false,
    'showCaption' => false,
];
?>
<div class="banner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'pictureForm' => $pictureForm,
        'array' => $array,
        'button' => '保存'
    ]) ?>

</div>
