<?php

namespace app\controllers;

use dektrium\user\controllers\SecurityController;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\web\Response;


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

        return ArrayHelper::merge(
            $parent,
            [
                [
                    'class' => ContentNegotiator::className(),
                    'only' => ['hello-world', 'login-json', 'logout-json'],
                    'formats' => [
                        'application/json' => Response::FORMAT_JSON
                    ]
                ]
            ]
        );
    }

    public function actionJLogin()
    {

    }

    public function actionJLogout()
    {

    }

    public function actionJSignUp()
    {

    }

}
