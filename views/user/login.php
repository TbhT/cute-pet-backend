<?php

use app\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '登录';
?>

<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'validateOnBlur' => true,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>

                <?= $form->field(
                    $model,
                    'login',
                    [
                        'inputOptions' => [
                            'autofocus' => 'autofocus',
                            'class' => 'form-control',
                            'tabindex' => '1',
                        ],
                    ])
                    ->label('手机号');
                ?>

                <?= $form->field(
                    $model,
                    'password',
                    ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])
                    ->textInput()
                    ->label('验证码')
                ?>

                <?=
                Html::a('发送验证码', null, [
                    'class' => 'btn btn-primary',
                    'id' => 'me-user-login-validate-code'
                ])
                ?>

                <?= $form->field(
                    $model,
                    'rememberMe')
                    ->checkbox(['tabindex' => '3', 'label' => '记住我'])
                ?>

                <?= Html::submitButton(
                    '登录',
                    ['class' => 'btn btn-primary btn-block', 'tabindex' => '4'])
                ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
