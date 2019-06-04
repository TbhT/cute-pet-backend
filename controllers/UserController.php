<?php

namespace app\controllers;

use app\models\RegisterForm;
use dektrium\user\controllers\SecurityController;
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

    public function actionJLogin()
    {
        $model = new LoginForm();
        $result = new \stdClass();

        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
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

    public function actionJLogout()
    {
        $result = new \stdClass();
        \Yii::$app->getUser()->logout();
        $result->iRet = 0;
        $result->message = 'success';
        $result->data = null;

        return $result;
    }

    public function actionJSignUp()
    {
        $model = new RegisterForm();
        $this->performAjaxValidation($model);
        $result = new \stdClass();

        if ($model->load(\Yii::$app->request->post()) && $model->register()) {
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

}
