<?php

namespace app\controllers;

use app\models\Activity;
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


class TUserController extends SecurityController
{
    public function behaviors()
    {
        $parent = parent::behaviors();
        array_push(
            $parent['access']['rules'],
            [
                'allow' => true,
                'actions' => ['j-login', 'j-sign-up', 'j-status', 'j-info'],
                'roles' => ['?']
            ],
            [
                'allow' => true,
                'actions' => ['j-all-pets', 'j-all-tweets', 'j-login', 'j-sign-up', 'j-status', 'j-info', 'j-activities'],
                'roles' => ['@']
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
                    'only' => ['j-login', 'j-sign-up', 'j-logout', 'j-status', 'j-all-pets', 'j-all-tweets', 'j-info', 'j-activities'],
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
            $result->data = $model->getFirstErrors();
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
     * @throws \yii\base\InvalidConfigException
     */
    public function actionJAllPets()
    {
        $result = new stdClass();

        $data = User::findOne(['userId' => Yii::$app->user->id])
            ->getPetsInfo()
            ->asArray()
            ->limit(10)
            ->all();

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
        $user = Yii::$app->user->identity;
        $offset = Yii::$app->request->post('offset');

        $data = Tweet::find()
            ->getTweetsByUserId($user->userId, $offset - 1)
            ->asArray()
            ->all();

        $tweets = [];
        foreach ($data as $d) {
            array_push($tweets, [
                'commentCount' => $d['commentCount'],
                'createTime' => $d['createTime'],
                'image' => $d['image'],
                'likeCount' => $d['likeCount'],
                'text' => $d['text'],
                'tweetId' => $d['tweetId'],
                'userId' => $user->userId,
                'avatar' => $user->image,
                'liked' => !empty($d['userLikeStatus'])
            ]);
        }

        $result->iRet = 0;
        $result->data = $tweets;
        $result->msg = 'success';

        return $result;
    }

    /**
     * 获取用户参加过的活动
     * @return stdClass
     * @throws \yii\base\InvalidConfigException
     */
    public function actionJActivities()
    {
        $result = new stdClass();
        $userId = Yii::$app->user->id;
        $offset = Yii::$app->request->post('offset');

        $activities = User::findOne(['userId' => $userId])
            ->getJoinActivities()
            ->limit(20)
            ->offset($offset - 1)
            ->asArray()
            ->all();

        $result->iRet = 0;
        $result->msg = 'success';
        $result->data = $activities;

        return $result;
    }

    /**
     * 获取用户的基本信息
     * @throws \yii\base\InvalidConfigException
     */
    public function actionJInfo()
    {
        $result = new stdClass();
        $userId = Yii::$app->user->id;

        $user = User::findOne(['userId' => $userId]);

        if ($user) {
            $pet = $user->getPetsInfo()->orderBy('createTime DESC')->one();
            if ($pet) {
                $pet = [
                    'petId' => $pet->petId,
                    'image' => $pet->image,
                    'nickname' => $pet->nickname
                ];
            }

            $userInfo = [
                'userId' => $user->userId,
                'image' => $user->image,
                'nickname' => $user->nickname,
            ];
        } else {
            $pet = null;
            $userInfo = null;

        }

        $result->iRet = 0;
        $result->msg = 'success';
        $result->data = [
            'userInfo' => $userInfo,
            'pet' => $pet
        ];

        return $result;
    }

    /**
     * 获取用户的详细信息
     */
    public function actionJDetailInfo()
    {
        $result = new stdClass();
        $userId = Yii::$app->user->id;
        $user = User::findOne(['userId' => $userId]);

        if ($user) {
            $userInfo = [
                'phoneNumber' => $user->username,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'age' => $user->age,
                'gender' => $user->gender,
                'homeAddress' => $user->homeAddress,
                'workAddress' => $user->workAddress,
                'image' => $user->image
            ];
        } else {
            $userInfo = null;
        }

        $result->iRet = 0;
        $result->msg = 'success';
        $result->data = $userInfo;

        return $result;
    }

}
