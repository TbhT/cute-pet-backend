<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "activity".
 *
 * @property string $activityId
 * @property int $status 活动审核状态
 * @property string $name 活动名称
 * @property string $beginTime 活动开始时间
 * @property string $endTime 活动结束时间
 * @property string $joinBeginTime 报名开始时间
 * @property string $joinEndTime 报名截止时间
 * @property string $organizer 主办方
 * @property string $coorganizer 协办方
 * @property string $place 活动地点
 * @property string $createTime 创建时间
 * @property string $updateTime 更新时间
 */
class Activity extends \yii\db\ActiveRecord
{
    // 待审核
    const UN_REVIEWED = 1;
    // 过审
    const PASSED = 2;

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
            [
                [
                    'name',
                    'beginTime',
                    'endTime',
                    'joinBeginTime',
                    'joinEndTime',
                    'organizer',
                    'coorganizer',
                    'place',
                    'personUnitPrice',
                    'petUnitPrice',
                    'province',
                    'city',
                    'area'
                ],
                'required'
            ],
            [['activityId', 'createTime', 'updateTime'], 'safe'],
            [['name'], 'string', 'max' => 32],
            [['organizer', 'coorganizer'], 'string', 'max' => 127],
            [['place'], 'string', 'max' => 255],
            [['personUnitPrice', 'petUnitPrice'], 'double'],
            [['activityId'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'activityId' => 'Activity ID',
            'status' => '活动审核状态',
            'name' => '活动名称',
            'beginTime' => '活动开始时间',
            'endTime' => '活动结束时间',
            'joinBeginTime' => '报名开始时间',
            'joinEndTime' => '报名截止时间',
            'organizer' => '主办方',
            'coorganizer' => '协办方',
            'place' => '活动地点',
            'personUnitPrice' => '元/人',
            'petUnitPrice' => '元/宠',
            'province' => '省',
            'city' => '市',
            'area' => '区',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
            'image' => '活动图片'
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
     * 获取省份列表
     * @return Activity[]|array
     */
    public static function getProvinceList()
    {
        $data = City::find()->groupBy('pId')->asArray()->all();
        $newData = [];
        array_map(function ($obj) use (&$newData) {
            $newData["{$obj['pId']}"] = $obj['province'];
        }, $data);

        return $newData;
    }

    public static function getCityList($pid)
    {
        $data = City::find()->andOnCondition(['pId' => $pid])->asArray()->all();
        $newData = [];

        array_map(function ($obj) use (&$newData) {
            $newData["{$obj['cId']}"] = $obj['city'];
        }, $data);

        return $newData;
    }

    public static function getAreaList($pid, $cid)
    {
        $data = City::find()->andOnCondition(['pId' => $pid, 'cId' => $cid])->asArray()->all();
        $newData = [];

        array_map(function ($obj) use (&$newData) {
            $newData["{$obj['pId']}"] = $obj['area'];
        }, $data);

        return $newData;
    }
}
