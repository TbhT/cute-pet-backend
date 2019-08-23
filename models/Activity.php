<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use app\utils\UploadImage;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


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
    const UN_REVIEWED = 0;
    // 过审
    const PASSED = 1;

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
                    'area',
                    'personCount',
                    'type'
                ],
                'required'
            ],
            [['provinceName', 'cityName', 'areaName', 'activityId', 'createTime', 'updateTime'], 'safe'],
            [['name'], 'string', 'max' => 32],
            [['organizer', 'coorganizer'], 'string', 'max' => 127],
            [['place'], 'string', 'max' => 255],
            [['personUnitPrice', 'petUnitPrice', 'personCount'], 'double'],
            [['activityId'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'activityId' => '活动id',
            'status' => '活动审核状态',
            'name' => '活动名称',
            'beginTime' => '活动开始时间',
            'endTime' => '活动结束时间',
            'joinBeginTime' => '报名开始时间',
            'joinEndTime' => '报名截止时间',
            'organizer' => '主办方',
            'coorganizer' => '协办方',
            'place' => '活动地点',
            'personUnitPrice' => '人单价 元/人',
            'petUnitPrice' => '宠物单价 元/宠',
            'province' => '省',
            'city' => '市',
            'area' => '区',
            'type' => '活动类型',
            'personCount' => '参与总人数',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
            'image' => '活动图片',
            'picture' => '活动封面图'
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
     * @param int $type
     * @return Activity[]|array
     */
    public static function getProvinceList($type = 1)
    {
        $data = City::find()->groupBy('pId')->asArray()->all();
        $newData = [];
        array_map(function ($obj) use (&$newData, $type) {
            $type === 1 ? $newData["{$obj['pId']}"] = $obj['province'] : $newData["{$obj['province']}"] = $obj['province'];
        }, $data);

        return $newData;
    }

    /**
     * @param $pid
     * @param int $type
     * @return array
     */
    public static function getCityList($pid, $type = 1)
    {
        $data = City::find()->andOnCondition(['pId' => $pid])->asArray()->all();
        $newData = [];

        array_map(function ($obj) use (&$newData, $type) {
            $type === 1 ? $newData["{$obj['cId']}"] = $obj['city'] : $newData["{$obj['city']}"] = $newData["${$obj['city']}"];
        }, $data);

        return $newData;
    }

    public static function getAreaList($cid, $type = 1)
    {
        $data = City::find()->andOnCondition(['cId' => $cid])->asArray()->all();
        $newData = [];

        array_map(function ($obj) use (&$newData, $type) {
            $type === 1 ? $newData[] = $obj['area'] : $newData["{$obj['area']}"] = $obj['area'];
        }, $data);

        return $newData;
    }
}
