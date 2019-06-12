<?php


namespace app\models;

use yii\base\Model;


class RegisterForm extends Model
{
    public $username;
    public $password;
    public $email;
    public $nickname;
    public $gender;
    public $age;
    public $name;
    public $homeAddress;
    public $workAddress;
    protected $user;

    public function rules()
    {
        return [
            [
                'username', 'match', 'pattern' => PHONE_REGEXP
            ],
            [
                'email', 'email'
            ],
            [
                'username', 'required'
            ],
            [
                'password', 'required'
            ],
            [
                'password', 'string', 'min' => 6, 'max' => 64
            ],
            [
                ['nickname', 'gender', 'age', 'name', 'homeAddress', 'workAddress'], 'safe'
            ]
        ];
    }

    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $this->user = $user;
        $this->loadAttributes($user);
        $user->password = $this->password;
//        var_dump($user);
//        var_dump($this);
        if (!$user->register()) {
            return false;
        }

        return true;
    }

    public function getUserModelErrors()
    {
        return $this->user->getErrorSummary(true);
    }

    protected function loadAttributes(User $user)
    {
        $user->setAttributes($this->attributes, false);
    }

}