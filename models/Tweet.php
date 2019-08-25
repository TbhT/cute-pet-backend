<?php

namespace app\models;

use app\utils\UploadImage;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\behaviors\GenerateIdBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
class Tweet extends ActiveRecord
{
    const NORMAL_STATUS = 0;
    public $picture;

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
            [['status', 'commentCount', 'likeCount'], 'integer'],
            [['text'], 'string'],
            [['image'], 'string', 'max' => 512],
            [['picture'], 'safe']
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['tweetId']
                ],
                'idType' => GenerateIdBehavior::TWEET_ID_TYPE
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tweetId' => '动态id',
            'userId' => '用户id',
            'status' => '动态状态',
            'text' => '内容',
            'image' => '图片',
            'commentCount' => '评论数',
            'likeCount' => '赞数',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
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

    /**
     * 获取tweet对应的用户信息
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['userId' => 'userId']);
    }

    /**
     * 获取tweet对应的赞总数
     * @return ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(LikeTweet::className(), ['tweetId' => 'tweetId']);
    }

    /**
     * 获取推特发表用户对本条推特的点赞状态
     * @return ActiveQuery
     */
    public function getUserLikeStatus()
    {
        return $this->hasOne(LikeTweet::className(), [
            'tweetId' => 'tweetId',
            'userId' => 'userId'
        ]);
    }

    /**
     * 获取tweet对应的评论总数
     * @return ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['tweetId' => 'tweetId']);
    }

    public function save($runValidation = true, $attributeNames = null, $path = '/images')
    {
        if ($this->picture) {
            $webImagePath = UploadImage::saveImage($this->picture, $path);
            $this->image = $webImagePath;
        }

        return parent::save($runValidation, $attributeNames);
    }

}
