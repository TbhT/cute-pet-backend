<?php


namespace app\models;

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
        try {
            if ($this->picture) {
                $file_array = explode(',', $this->picture);
                $match = '|data:image/(\w+)|';
                preg_match($match, $file_array[0], $image_extension);
                $webImagePath = '/images/' . md5($file_array[1]) . '_' . time() . '.' . $image_extension[1];
                $filename = Yii::getAlias('@webroot') . $webImagePath;
                $user->image = $webImagePath;
                $file = base64_decode($file_array[1]);
                if (!file_put_contents($filename, $file)) {
                    $result = new \stdClass();
                    $result->iRet = 0;
                    $result->msg = 'success';
                    $result->data = [
                        'filename' => $filename
                    ];
                    Yii::error($result);
                    throw new \Error('图片保存失败');
                }
            }
        } catch (Throwable $e) {
            Yii::error($e);
        }

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