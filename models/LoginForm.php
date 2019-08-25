<?php

namespace app\models;

use function GuzzleHttp\Promise\all;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $login;
    public $password;
    public $rememberMe = true;

    private $_user;

    const PHONE_REGEXP = '/^(?=\\d{11}$)^1(?:3\\d|4[57]|5[^4\\D]|66|7[^249\\D]|8\\d|9[89])\\d{8}$/';

    /**
     * @return array the validation rbac.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['login'], 'required', 'message' => '手机号不能为空'],
            ['login', 'match', 'pattern' => static::PHONE_REGEXP, 'message' => '手机号无效'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['password', 'required', 'message' => '验证码不能为空']
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password, $this->login)) {
                $this->addError('password', '验证码不正确');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if (!$this->_user) {
                $this->addError('login', '手机号不正确');
                return false;
            }

            return Yii::$app->getUser()->login($this->_user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->_user = $this->getUser();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[mobile]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if (!$this->_user) {
            $this->_user = User::findOne(['mobile' => $this->login]);
            if (!$this->_user) {
                $user = new User();
                $user->mobile = $this->login;
                if ($user->save()) {
                    $this->_user = $user;
                } else {
                    Yii::error($user->getErrorSummary(true));
                }
            }
        }

        return $this->_user;
    }
}
