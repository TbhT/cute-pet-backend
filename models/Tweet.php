<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use app\behaviors\GenerateIdBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tweet".
 *
 * @property string $tweetId
 * @property string $userId
 * @property int $status
 * @property string $text
 * @property string $image
 * @property int $commentCount
 * @property int $likeCount
 * @property string $createTime
 * @property string $updateTime
 */
class Tweet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tweet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['status', 'commentCount', 'likeCount'], 'integer'],
            [['text'], 'string'],
            [['userId'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 512],
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['tweetId']
                ],
                'idType' => GenerateIdBehavior::PET_ID_TYPE
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tweetId' => 'Tweet ID',
            'userId' => 'User ID',
            'status' => 'Status',
            'text' => 'Text',
            'image' => 'Image',
            'commentCount' => 'Comment Count',
            'likeCount' => 'Like Count',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TweetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TweetQuery(get_called_class());
    }
}
