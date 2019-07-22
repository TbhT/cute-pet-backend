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
    // 两人一宠
    const TYPE_TWO_ONE = 1;
    // 两人两宠
    const TYPE_TWO_TWO = 2;
    // 一人两宠
    const TYPE_ONE_TWO = 3;
    // 一人一宠
    const TYPE_ONE_ONE = 4;

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
            [['amount'], 'double'],
            [['type', 'amount'], 'required'],
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
            'tag' => '参与人必填字段',
            'type' => '支付类型',
            'amount' => '金额',
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
