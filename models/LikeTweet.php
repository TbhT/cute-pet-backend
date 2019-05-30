<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "like_tweet".
 *
 * @property int $likeId
 * @property int $tweetId
 * @property string $userId
 * @property string $createTime
 * @property string $updateTime
 */
class LikeTweet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'like_tweet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['likeId', 'userId'], 'required'],
            [['likeId', 'tweetId'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['userId'], 'string', 'max' => 255],
            [['likeId'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'likeId' => 'Like ID',
            'tweetId' => 'Tweet ID',
            'userId' => 'User ID',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }

    /**
     * {@inheritdoc}
     * @return LikeTweetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LikeTweetQuery(get_called_class());
    }
}
