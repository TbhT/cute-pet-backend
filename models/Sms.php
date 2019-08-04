<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "sms".
 *
 * @property string $id
 * @property string $reqId
 * @property string $phoneNumber
 * @property string $code
 * @property string $createTime 创建时间
 * @property string $updateTime 更新时间
 */
class Sms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createTime', 'updateTime'], 'safe'],
            [['reqId', 'code'], 'string', 'max' => 255],
            [['phoneNumber'], 'string', 'max' => 32],
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
            ]
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reqId' => 'Req ID',
            'phoneNumber' => 'Phone Number',
            'code' => 'Code',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SmsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SmsQuery(get_called_class());
    }
}
