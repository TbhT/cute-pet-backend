<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use app\utils\UploadImage;
use DateTime;
use DateTimeZone;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\StaleObjectException;
use yii\web\IdentityInterface;


const PHONE_REGEXP = '/^(?=\\d{11}$)^1(?:3\\d|4[57]|5[^4\\D]|66|7[^249\\D]|8\\d|9[89])\\d{8}$/';


class User extends ActiveRecord implements IdentityInterface
{

    public $picture;

    public static function tableName()
    {
        return 'user';
    }


    public function rules()
    {
        return [
            [
                'mobile', 'match', 'pattern' => PHONE_REGEXP
            ],
            [
                [
                    'name',
                    'nickname',
                    'birth',
                    'city',
                    'province',
                    'address',
                    'idCard'
                ],
                'string'
            ],
            [
                [
                    'age',
                    'high',
                    'gender'
                ],
                'integer'
            ],
            [
                [
                    'picture'
                ],
                'safe'
            ],
            [['userId'], 'unique']
        ];
    }

    public function getAuthKey()
    {
        return $this->getAttribute('auth_key');
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAttribute('auth_key') === $authKey;
    }

    public function behaviors()
    {
        return [
            [
                'class' => GenerateIdBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['userId']
                ],
                'idType' => GenerateIdBehavior::USER_ID_TYPE
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createTime', 'updateTime'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updateTime']
                ],
                'value' => new Expression('NOW()')
            ],
        ];
    }

    /**
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->getAttribute('userId');
    }

    /**
     * 查询一个用户是否是管理员
     * @return bool
     */
    public function getIsAdmin()
    {
        $auth = Yii::$app->authManager;
        $userIds = $auth->getUserIdsByRole('admin');
        return in_array($this->userId, $userIds);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['userId' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    public function attributeLabels()
    {
        return [
            'userId' => '用户唯一标识',
            'mobile' => '手机号',
            'avatar' => '头像地址',
            'name' => '姓名',
            'nickname' => '昵称',
            'birth' => '出生年月',
            'gender' => '性别',
            'age' => '年纪',
            'city' => '城市',
            'province' => '省份',
            'address' => '家庭详细住址',
            'idCard' => '身份证号',
            'high' => '身高',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
            'password' => '密码'
        ];
    }


    /**
     * @param $password
     * @param $phone
     * @return bool
     * @throws Throwable
     */
    public function validatePassword($password, $phone)
    {
        $sms = Sms::find()
            ->where(['phoneNumber' => $phone, 'code' => $password])
            ->orderBy('createTime DESC')
            ->limit(1)
            ->one();

        if ($sms) {
            $timezone = new DateTimeZone('asia/shanghai');
            $createTime = new DateTime($sms->createTime, $timezone);
            $now = new DateTime('now', $timezone);
            $diff = $now->diff($createTime);

            if ($diff->y == 0 && $diff->m == 0 && $diff->d == 0 && $diff->h == 0 && $diff->i <= 5) {
                return true;
            }

            return false;
        } else {
            return false;
        }
    }

    /**
     * 获取用户的所有宠物信息
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getPetsInfo()
    {
        return $this->hasMany(Pet::className(), ['petId' => 'petId'])
            ->viaTable('user_pet', ['userId' => 'userId']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getJoinActivities()
    {
        return $this->hasMany(Activity::className(), ['activityId' => 'activityId'])
            ->viaTable('activity_user', ['userId' => 'userId']);
    }

    public function save($runValidation = true, $attributeNames = null, $path = '/images')
    {
        if ($this->picture) {
            $webImagePath = UploadImage::saveImage($this->picture, $path);
            $this->avatar = $webImagePath;
        }

        return parent::save($runValidation, $attributeNames);
    }


}
