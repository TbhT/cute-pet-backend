<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use app\behaviors\GenerateIdBehavior;
use yii\db\ActiveRecord;

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
            [['userId'], 'string', 'max' => 255],
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
            'commentId' => 'Comment ID',
            'tweetId' => 'Tweet ID',
            'userId' => 'User ID',
            'status' => 'Status',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
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
}
