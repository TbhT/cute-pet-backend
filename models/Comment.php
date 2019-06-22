<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use app\behaviors\GenerateIdBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "comment".
 *
 * @property int $commentId
 * @property int $tweetId
 * @property string $userId
 * @property int $status
 * @property string $createTime
 * @property string $updateTime
 */
class Comment extends ActiveRecord
{
    const NORMAL = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId'], 'required'],
            [['tweetId', 'status'], 'integer'],
            [['text'], 'string', 'max' => 255],
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['commentId']
                ],
                'idType' => GenerateIdBehavior::COMMENT_ID_TYPE
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'commentId' => '评论id',
            'tweetId' => '动态id',
            'userId' => '用户id',
            'text' => '评论内容',
            'status' => '评论状态',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return CommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommentQuery(get_called_class());
    }

    /**
     * 获取评论对应的用户信息
     */
    public function getUserInfo()
    {
        return $this->hasOne(User::className(), ['userId' => 'userId']);
    }
}
