<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;


class AdminController extends Controller
{
    public function actionCreate($username)
    {
        $user = User::findOne(['mobile' => $username]);
        if (!$user) {
            $message = $this->ansiFormat("用户 手机号 不存在", Console::FG_RED);
            echo "$message";
            return;
        }

        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');
        $auth->assign($role, $user->userId);
    }
}