<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


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
            [['userId'], 'string', 'max' => 255],
            [['likeId'], 'unique'],
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
            ]
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
