<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
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
class LikeTweet extends ActiveRecord
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
            [['userId'], 'required'],
            [['tweetId'], 'integer'],
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['likeId']
                ],
                'idType' => GenerateIdBehavior::LIKE_TWEET_ID_TYPE
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'likeId' => '赞id',
            'tweetId' => '动态id',
            'userId' => '用户id',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
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
