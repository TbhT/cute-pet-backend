<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "area_code".
 *
 * @property string $id
 * @property int $type 层级
 * @property string $name 名称
 * @property string $parent_id 上级代码
 * @property string $zip 邮编
 */
class AreaCode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'area_code';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['type'], 'integer'],
            [['id', 'parent_id', 'zip'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 64],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '层级',
            'name' => '名称',
            'parent_id' => '上级代码',
            'zip' => '邮编',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AreaCodeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AreaCodeQuery(get_called_class());
    }

    public static function getProvinceList()
    {
        $all = static::find()->where(['parent_id' => 1])->asArray()->all();
        return ArrayHelper::map($all, 'id', 'name');
    }


}
