<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use app\utils\UploadImage;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "market".
 *
 * @property string $marketId
 * @property string $userId
 * @property int $status
 * @property string $name
 * @property string $contact
 * @property string $phoneNumber
 * @property string $createTime
 * @property string $updateTime
 * @property bool|string image
 */
class Market extends ActiveRecord
{
    public $picture;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'market';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId'], 'required'],
            [['userId', 'status'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [['contact'], 'string', 'max' => 16],
            [['phoneNumber'], 'string', 'max' => 32],
            [['picture', 'serveType'], 'safe'],
            [['intro', 'place'], 'string', 'max' => 512],
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['marketId']
                ],
                'idType' => GenerateIdBehavior::MARKET_ID_TYPE
            ]
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'marketId' => 'Market ID',
            'userId' => 'User ID',
            'status' => 'Status',
            'name' => 'Name',
            'contact' => 'Contact',
            'intro' => '简介',
            'serveType' => '服务类型',
            'workTime' => '工作时间',
            'phoneNumber' => 'Phone Number',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MarketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MarketQuery(get_called_class());
    }

    public function save($runValidation = true, $attributeNames = null, $path = 'images')
    {
        $webImagePath = UploadImage::saveImage($this->picture, 'images');
        $this->image = $webImagePath;
        $this->userId = Yii::$app->user->id;

        return parent::save($runValidation, $attributeNames);
    }
}
