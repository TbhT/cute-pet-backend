<?php


namespace app\models;

use yii\base\Model;


class LoginUserForm extends Model
{
    public $mobile;
    public $identityCode;

    private $_user;

    public function rules()
    {
        return [
            [
                ['mobile'], 'required'
            ],
            [
                ['identityCode'], 'string', 'required'
            ]
        ];
    }

    public function validateIdentityCode()
    {
//        todo: 需要补充验证码的接口
        return false;
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->_user = $this->getUser();
            return true;
        }

        return false;
    }

    public function getUser()
    {
        if (!$this->_user) {
            $this->_user = User::findOne(['mobile' => $this->mobile]);
        }

        return $this->_user;
    }
}