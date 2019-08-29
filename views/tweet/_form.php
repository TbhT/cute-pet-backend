<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tweet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tweet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'status')->dropDownList(
        [
            0 => '正常',
            1 => '屏蔽'
        ]
    )
    ?>

    <div class="form-group">
        <?= Html::submitButton('更新', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
