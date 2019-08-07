<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "banner".
 *
 * @property string $bannerId
 * @property string $image
 * @property string $createTime
 * @property string $updateTime
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bannerId'], 'integer'],
            [['name'], 'string'],
            [['createTime', 'updateTime'], 'safe'],
            [['image'], 'string', 'max' => 512],
            [['bannerId'], 'unique'],
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['bannerId']
                ],
                'idType' => GenerateIdBehavior::ACTIVITY_ID_TYPE
            ]
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bannerId' => 'Banner ID',
            'image' => '图片地址',
            'name' => '轮播图名称',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return BannerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BannerQuery(get_called_class());
    }
}
