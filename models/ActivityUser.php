<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_user".
 *
 * @property string $auId
 * @property string $activityId 活动id
 * @property string $userId 用户id
 * @property string $createTime
 * @property string $updateTime
 */
class ActivityUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activityId', 'userId'], 'required'],
            [['activityId', 'userId'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'auId' => 'Au ID',
            'activityId' => 'Activity ID',
            'userId' => 'User ID',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ActivityUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActivityUserQuery(get_called_class());
    }
}
