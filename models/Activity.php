<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "activity".
 *
 * @property string $activityId
 * @property int $status
 * @property string $name
 * @property string $beginTime
 * @property string $endTime
 * @property string $joinBeginTime
 * @property string $joinEndTime
 * @property string $organizer
 * @property string $coorganizer
 * @property string $place
 * @property string $createTime
 * @property string $updateTime
 */
class Activity extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['beginTime', 'endTime', 'joinBeginTime', 'joinEndTime'], 'safe'],
            [['place'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 32],
            [['organizer', 'coorganizer'], 'string', 'max' => 127],
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
                ]
            ],
            [
                'class' => GenerateIdBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['activityId']
                ],
                'idType' => GenerateIdBehavior::ACTIVITY_ID_TYPE
            ]
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'activityId' => '活动id',
            'status' => '活动状态',
            'name' => '活动名称',
            'beginTime' => '活动开始时间',
            'endTime' => '活动结束时间',
            'joinBeginTime' => '报名开始时间',
            'joinEndTime' => '报名截止时间',
            'organizer' => '主办方',
            'coorganizer' => '协办方',
            'place' => '活动地点',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ActivityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActivityQuery(get_called_class());
    }
}
