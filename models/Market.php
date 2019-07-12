<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;


/**
 * This is the model class for table "market".
 *
 * @property string $marketId
 * @property string $userId
 * @property int $status
 * @property string $name 商家名称
 * @property string $contact 联系人
 * @property string $phone 联系方式
 * @property string $createTime 创建时间
 * @property string $updateTime 更新时间
 */
class Market extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'market';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['marketId', 'userId', 'status'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['name'], 'string', 'max' => 256],
            [['contact', 'phone'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'marketId' => 'Market ID',
            'userId' => 'User ID',
            'status' => 'Status',
            'name' => '商家名称',
            'contact' => '联系人',
            'phone' => '联系方式',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['marketId']
                ],
                'idType' => GenerateIdBehavior::MARKET_ID_TYPE
            ]
        ];
    }

    /**
     * {@inheritdoc}
     * @return MarketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MarketQuery(get_called_class());
    }
}
