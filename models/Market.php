<?php

namespace app\models;

use app\utils\UploadImage;
use Yii;

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
class Market extends \yii\db\ActiveRecord
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
            [['marketId', 'userId'], 'required'],
            [['marketId', 'userId', 'status'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [['contact'], 'string', 'max' => 16],
            [['phoneNumber'], 'string', 'max' => 32],
            [['marketId'], 'unique'],
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
        return parent::save($runValidation, $attributeNames);
    }
}
