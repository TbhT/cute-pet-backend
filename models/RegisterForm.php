<?php


namespace app\models;

use app\utils\UploadImage;
use Throwable;
use Yii;
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
    public $picture;
    protected $user;

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
            ],
            [
                ['email', 'nickname', 'gender', 'age', 'name', 'homeAddress', 'workAddress', 'picture'], 'safe'
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

        // save image
        $webImagePath = UploadImage::saveImage($this->picture, 'images');
        $user->image = $webImagePath;

        if (!$user->register()) {
            return false;
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getUserInfo()
    {
        return $this->user;
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