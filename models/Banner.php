<?php

namespace app\models;

use Yii;

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
            [['bannerId'], 'required'],
            [['bannerId'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['image'], 'string', 'max' => 512],
            [['bannerId'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bannerId' => 'Banner ID',
            'image' => 'Image',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
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
