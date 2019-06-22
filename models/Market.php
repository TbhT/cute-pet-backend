<?php

namespace app\models;

use app\utils\UploadImage;
use Yii;
use yii\db\ActiveRecord;

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
            [['picture'], 'safe']
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
