<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "activity_user".
 *
 * @property int $id
 * @property string $userId
 * @property string $name 随行人姓名
 * @property string $phone 随行人电话
 * @property string $relation 随行人关系
 * @property string $size 随行人尺寸
 * @property string $activityId 活动id
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
            [['userId', 'activityId'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['name', 'phone', 'relation', 'size'], 'string', 'max' => 32],
            [['userId', 'activityId'], 'unique', 'targetAttribute' => ['userId', 'activityId']],
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
            'name' => '随行人姓名',
            'phone' => '随行人电话',
            'relation' => '随行人关系',
            'size' => '随行人尺寸',
            'activityId' => '活动id',
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
     * @return ActivityUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActivityUserQuery(get_called_class());
    }
}
