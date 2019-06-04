<?php


namespace app\models;

use yii\base\Model;

const PHONE_REGEXP = '/^(?=\\d{11}$)^1(?:3\\d|4[57]|5[^4\\D]|66|7[^249\\D]|8\\d|9[89])\\d{8}$/';


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

    public function rules()
    {
        return [
            [
                'username', 'match', 'pattern' => PHONE_REGEXP
            ],
            [
                'username', 'required'
            ],
            [
                'password', 'required'
            ],
            [
                'password', 'string', 'min' => 6, 'max' => 64
            ]
        ];
    }

    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $this->loadAttributes($user);

        if (!$user->register()) {
            return false;
        }

        return true;
    }

    protected function loadAttributes(User $user)
    {
        $user->setAttributes($this->attributes);
    }

}