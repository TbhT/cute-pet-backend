<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "topic".
 *
 * @property string $topicId
 * @property string $text
 * @property string $createTime
 * @property string $updateTime
 */
class Topic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'topic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
            [['createTime', 'updateTime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'topicId' => 'Topic ID',
            'text' => 'Text',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TopicQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TopicQuery(get_called_class());
    }

}
