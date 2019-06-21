<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use dektrium\user\helpers\Password;
use dektrium\user\models\Token;
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

    public function register()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $transaction = $this->getDb()->beginTransaction();

        try {
            $this->confirmed_at = $this->module->enableConfirmation ? null : time();
            $this->password = $this->module->enableGeneratingPassword ? Password::generate(8) : $this->password;

            $this->trigger(self::BEFORE_REGISTER);

            if (!$this->save()) {
                $transaction->rollBack();
                return false;
            }

            if ($this->module->enableConfirmation) {
                /** @var Token $token */
                $token = \Yii::createObject(['class' => Token::className(), 'type' => Token::TYPE_CONFIRMATION]);
                $token->link('user', $this);
            }

            $this->trigger(self::AFTER_REGISTER);

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            \Yii::warning($e->getMessage());
            throw $e;
        }
    }


    /**
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->getAttribute('userId');
    }

    public static function findIdentity($id)
    {
        return static::findOne(['userId' => $id]);
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
     * @throws \yii\base\InvalidConfigException
     */
    public function getPetsInfo()
    {
        return $this->hasMany(Pet::className(), ['petId' => 'petId'])
            ->viaTable('user_pet', ['userId' => 'userId']);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }
}
