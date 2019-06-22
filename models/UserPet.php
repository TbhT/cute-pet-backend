<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "user_pet".
 *
 * @property int $id
 * @property string $userId
 * @property string $petId
 * @property string $createTime
 * @property string $updateTime
 */
class UserPet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_pet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'petId'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['userId', 'petId'], 'unique', 'targetAttribute' => ['userId', 'petId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'petId' => 'Pet ID',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createTime', 'updateTime'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updateTime']
                ],
                'value' => new Expression('NOW()')
            ]
        ];
    }


    /**
     * {@inheritdoc}
     * @return UserPetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserPetQuery(get_called_class());
    }
}
