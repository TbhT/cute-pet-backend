<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use dektrium\user\helpers\Password;
use dektrium\user\models\User as BaseUser;
use Yii;
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

    /**
     * @return array
     */
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

    /**
     * @return int|mixed|string
     */
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

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Password::validate($password, $this->password_hash);
    }

    /**
     * 获取用户的所有宠物信息
     * @return \yii\db\ActiveQuery
     */
    public function getPetsInfo()
    {
        return $this->hasMany(Pet::className(), ['userId' => 'userId']);
    }
}
