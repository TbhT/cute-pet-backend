<?php

namespace app\controllers;

use app\models\Pet;
use app\models\RegisterForm;
use app\models\Tweet;
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
                'actions' => ['j-login', 'j-sign-up'],
                'roles' => ['?']
            ],
            [
                'allow' => true,
                'actions' => ['j-login'],
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
                    'only' => ['j-login', 'j-sign-up', 'j-logout'],
                    'formats' => [
                        'application/json' => Response::FORMAT_JSON
                    ]
                ]
            ]
        );
    }

    /**
     * @return stdClass
     */
    public function actionJLogin()
    {
        $model = new LoginForm();
        $result = new stdClass();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $result->iRet = 0;
            $result->message = 'success';
            $result->data = null;
        } else {
            $result->iRet = -1;
            $result->message = 'login failed';
            $result->data = $model->getErrorSummary(true);
        }

        return $result;
    }

    /**
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

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            $result->iRet = 0;
            $result->message = 'success';
            $result->data = null;
        } else {
            $result->iRet = -1;
            $result->message = 'sign up failed';
            $result->data = $model->getErrorSummary(true);
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

}
