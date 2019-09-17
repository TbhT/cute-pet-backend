<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$auth = Yii::$app->authManager;
$userIds = $auth->getUserIdsByRole('admin');
$isAdmin = in_array(Yii::$app->user->id, $userIds);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '后台管理系统',
        'brandUrl' => '/activity',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' =>
            !$isAdmin ?
                ([
                    ['label' => '登录', 'url' => '/user/login']
                ])
                :
                [
                    ['label' => '报名管理', 'url' => '/activity-user'],
                    ['label' => '订单管理', 'url' => '/order'],
                    ['label' => '活动管理', 'url' => '/activity'],
                    ['label' => '动态管理', 'url' => '/tweet'],
                    ['label' => '轮播图管理', 'url' => '/banner'],
                    ['label' => '评论管理', 'url' => '/comment'],
                    ['label' => '宠物管理', 'url' => '/pet'],
                    ['label' => '商家管理', 'url' => '/market'],
                    ['label' => '话题管理', 'url' => '/topic'],
                    ['label' => '用户管理', 'url' => '/user'],
                    (
                        '<li>'
                        . Html::beginForm(['/user/logout'], 'post')
                        . Html::submitButton(
                            '退出 (' . Yii::$app->user->identity->mobile . ')',
                            ['class' => 'btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>'
                    )
                ]
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <!--        <p class="pull-left">&copy; My Company --><? //= date('Y') ?><!--</p>-->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
