<?php

namespace app\controllers;

use app\models\Pet;
use app\models\RegisterForm;
use app\models\Tweet;
use app\models\User;
use dektrium\user\controllers\SecurityController;
use stdClass;
use Yii;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use app\models\LoginForm;


class UserController extends SecurityController
{
    public function behaviors()
    {
        $parent = parent::behaviors();
        array_push(
            $parent['access']['rules'],
            [
                'allow' => true,
                'actions' => ['j-login', 'j-sign-up', 'j-status', 'j-all-pets', 'j-all-tweets'],
                'roles' => ['?']
            ]
        );

        $parent['verbs']['actions'] = ArrayHelper::merge(
            $parent['verbs']['actions'],
            [
                'j-login' => ['post'],
                'j-logout' => ['post'],
                'j-sign-up' => ['post']
            ]
        );

        return ArrayHelper::merge(
            $parent,
            [
                [
                    'class' => ContentNegotiator::className(),
                    'only' => ['j-login', 'j-sign-up', 'j-logout', 'j-status', 'j-all-pets', 'j-all-tweets'],
                    'formats' => [
                        'application/json' => Response::FORMAT_JSON
                    ]
                ]
            ]
        );
    }

    /**
     * 获取用户的登录状态
     * @return stdClass
     */
    public function actionJStatus()
    {
        $result = new stdClass();
        $result->iRet = 0;
        $result->msg = 'success';

        if (Yii::$app->user->identity) {
            $result->data = [
                'userId' => Yii::$app->user->id
            ];
        } else {
            $result->data = [
                'userId' => null
            ];
        }

        $result->data = [
            'userId' => null
        ];

        return $result;
    }

    /**
     * 用户登录
     * @return stdClass
     */
    public function actionJLogin()
    {
        $model = new LoginForm();
        $result = new stdClass();

        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            $user = User::findOne(['username' => $model->username]);
            $result->iRet = 0;
            $result->message = 'success';
            $result->data = [
                'userId' => $user->userId,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'gender' => $user->gender
            ];
        } else {
            $result->iRet = -1;
            $result->message = 'login failed';
            $result->data = $model->getErrorSummary(true);
        }

        return $result;
    }

    /**
     * 用户退出
     * @return stdClass
     */
    public function actionJLogout()
    {
        $result = new stdClass();
        Yii::$app->getUser()->logout();

        $result->iRet = 0;
        $result->message = 'success';
        $result->data = null;

        return $result;
    }

    /**
     * 注册
     * @return stdClass
     * @throws \yii\base\ExitException
     */
    public function actionJSignUp()
    {
        $model = new RegisterForm();
        $this->performAjaxValidation($model);
        $result = new stdClass();

        if ($model->load(Yii::$app->request->post(), '') && $model->register()) {
            $result->iRet = 0;
            $result->message = 'success';
            $result->data = $model->getUserInfo();
        } else {
            $userModelError = $model->getUserModelErrors();

            if (!empty($userModelError)) {
                $result->iRet = -2;
                $result->message = 'user error';
                $result->data = $userModelError;
            } else {
                $result->iRet = -1;
                $result->message = 'sign up failed';
                $result->data = $model->getErrorSummary(true);
            }
        }

        return $result;
    }

    /**
     * 获取所有的宠物
     * @return stdClass
     */
    public function actionJAllPets()
    {
        $result = new stdClass();
        $data = Pet::find()->getAllPersonPets(Yii::$app->user->id)->asArray();

        $result->iRet = 0;
        $result->msg = 'success';
        $result->data = $data;

        return $result;
    }

    /**
     * 获取用户所有的动态信息
     * @return stdClass
     */
    public function actionJAllTweets()
    {
        $result = new stdClass();
        $userId = Yii::$app->user->id;
        $offset = Yii::$app->request->post('offset');

        $data = Tweet::find()->getTweetsByUserId($userId, $offset);

        $result->iRet = 0;
        $result->data = $data;
        $result->msg = 'success';

        return $result;
    }

    /**
     * 获取用户的基本信息
     */
    public function actionJInfo()
    {
        $result = new stdClass();
        $userId = Yii::$app->user->id;
        $user = User::findOne(['userId' => $userId]);
        $pet = $user->getPetsInfo()->orderBy('createTime DESC')->one();

        $result->iRet = 0;
        $result->msg = 'success';
        $result->data = [
            'userInfo' => $user->toArray(),
            'pet' => $pet
        ];
    }

    /**
     * 获取用户的详细信息
     */
    public function actionJDetailInfo()
    {
        $result = new stdClass();
        $userId = Yii::$app->user->id;
        $user = User::findOne(['userId' => $userId]);

        $result->iRet = 0;
        $result->msg = 'success';
        $result->data = [];
    }

}
