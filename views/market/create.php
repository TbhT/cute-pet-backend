<?php

use app\models\UploadForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Market */
/* @var $pictureForm app\models\UploadForm */

$this->title = '添加商户';
$this->params['breadcrumbs'][] = ['label' => '商户', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$array = [
    'removeLabel' => '清除',
    'language' => 'zh',
    'overwriteInitial' => false,
    'showUpload' => false,
    'showCaption' => false,
];
?>

<div class="market-create">

    <?= $this->render('_form', [
        'model' => $model,
        'pictureForm' => $pictureForm,
        'array' => $array,
        'button' => '保存'
    ]) ?>

</div>
