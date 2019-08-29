<?php

namespace app\models;

use Yii;

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
 * @property string $tag
 * @property int $type 支付类型
 * @property double $amount 金额
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
            [['userId', 'activityId', 'type'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['amount'], 'number'],
            [['name', 'phone', 'relation', 'size'], 'string', 'max' => 32],
            [['tag'], 'string', 'max' => 255],
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
            'userId' => '用户id',
            'name' => '随行人姓名',
            'phone' => '随行人电话',
            'relation' => '随行人关系',
            'size' => '随行人尺寸',
            'activityId' => '活动id',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
            'tag' => 'Tag',
            'type' => '支付类型',
            'amount' => '金额',
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

    public function getUserInfo()
    {
        return $this->hasOne(User::className(), ['userId' => 'userId']);
    }

    public function getActivityInfo()
    {
        return $this->hasOne(Activity::className(), ['activityId' => 'activityId']);
    }
}
