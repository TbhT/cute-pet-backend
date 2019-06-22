<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use app\utils\UploadImage;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
 * @property bool|string image
 */
class Activity extends ActiveRecord
{
    const COMPETE_ACTIVITY = 1;
    const PARTY_ACTIVITY = 2;
    const TRAVEL_ACTIVITY = 3;

    const REVIEW_STATUS = 2;
    const SUBMIT_STATUS = 1;

    public $picture;

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
            [['image'], 'string', 'max' => 256],
            [['picture', 'totalCount', 'totalCost'], 'safe']
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

    public function save($runValidation = true, $attributeNames = null, $path = 'images')
    {
        $webImagePath = UploadImage::saveImage($this->picture, 'images');
        $this->image = $webImagePath;
        return parent::save($runValidation, $attributeNames);
    }
}
