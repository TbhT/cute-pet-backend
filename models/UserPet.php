<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_pet".
 *
 * @property int $id
 * @property string $userId
 * @property string $petId
 * @property int $status 关系
 * @property string $createTime 创建时间
 * @property string $updateTime 更新时间
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
            [['userId', 'petId', 'status'], 'integer'],
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
            'status' => '关系',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
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
