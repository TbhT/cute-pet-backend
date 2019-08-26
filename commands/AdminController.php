<?php

namespace app\commands;

use app\models\City;
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

    public function actionProvinceData()
    {
        $data = file_get_contents(__DIR__ . '/../console/pca.json');
        $data = json_decode($data);
        $i = time() + 1;
        $ii = time() + 11;

        foreach ($data as $key => $province) {
            foreach ($province as $cityKey => $city) {
                foreach ($city as $c) {
                    echo "{$key}-{$cityKey}-{$c}\n";
                    $m = new City();
                    $m->province = $key;
                    $m->city = $cityKey;
                    $m->area = $c;
                    $m->pId = $i;
                    $m->cId = $ii;
                    if ($m->save() === false) {
                        print_r($m->getErrorSummary(true));
                    }
                }
                $ii++;
            }
            $i++;
        }
    }
}