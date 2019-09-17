<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "order".
 *
 * @property string $orderId 订单id
 * @property int $status 订单状态
 * @property string $userId 用户id
 * @property int $petCount 宠物数
 * @property int $personCount 人数
 * @property  int $activityId 赛事id
 * @property int $totalFee 订单总金额
 * @property string $name 商品名称
 * @property string $createTime 创建时间
 * @property string $updateTime 更新时间
 */
class Order extends \yii\db\ActiveRecord
{
    const CREATE = 1;
    const PAY = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'totalFee'], 'required'],
            [['activityId', 'orderId', 'status', 'userId', 'totalFee', 'petCount', 'personCount'], 'integer'],
            [['createTime', 'updateTime', 'orderId'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'orderId' => '订单id',
            'status' => '订单状态',
            'userId' => '用户id',
            'totalFee' => '总金额',
            'name' => '订单名称',
            'personCount' => '人数',
            'petCount' => '宠物数',
            'activityId' => '赛事id',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderQuery(get_called_class());
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['orderId']
                ],
                'idType' => GenerateIdBehavior::ORDER_ID_TYPE
            ]
        ];
    }

    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['activityId' => 'activityId']);
    }
}
