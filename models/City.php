<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "city".
 *
 * @property string $id
 * @property string $province 省份
 * @property string $city 城市
 * @property string $area 区
 * @property string $createTime 创建时间
 * @property string $updateTime 更新时间
 * @property int pId
 * @property int cId
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createTime', 'updateTime'], 'safe'],
            [['province', 'city'], 'string', 'max' => 16],
            [['area'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province' => '省份',
            'city' => '城市',
            'area' => '区',
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
            ]
        ];
    }

}
