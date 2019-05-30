<?php

namespace app\models;

use Yii;

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
            [['tweetId', 'text'], 'required'],
            [['tweetId', 'status', 'commentCount', 'likeCount'], 'integer'],
            [['text'], 'string'],
            [['createTime', 'updateTime'], 'safe'],
            [['userId'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 512],
            [['tweetId'], 'unique'],
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
