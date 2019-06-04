<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use dektrium\user\models\User as BaseUser;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


const PHONE_REGEXP = '/^(?=\\d{11}$)^1(?:3\\d|4[57]|5[^4\\D]|66|7[^249\\D]|8\\d|9[89])\\d{8}$/';


class User extends BaseUser
{
    public function behaviors()
    {
        $parent = parent::behaviors();
        return ArrayHelper::merge($parent, [
            [
                'class' => GenerateIdBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['userId']
                ],
                'idType' => GenerateIdBehavior::USER_ID_TYPE
            ]
        ]);
    }

    public function rules()
    {
        $rules = parent::rules();
        unset($rules['emailRequired']);
        return ArrayHelper::merge($rules, [
            [
                'username',
                'match',
                'pattern' => PHONE_REGEXP
            ]
        ]);
    }

    public function getId()
    {
        return $this->getAttribute('userId');
    }

    public function attributeLabels()
    {
        return [
            'username' => '手机号',
            'password' => '密码'
        ];
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
}
