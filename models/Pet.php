<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "pet".
 *
 * @property string $petId
 * @property int $status
 * @property string $nickname 昵称
 * @property int $gender 性别
 * @property int $age 年龄
 * @property int $vaccineStatus 疫苗状态
 * @property int $petType 宠物类别
 * @property string $subtype 宠物品类
 * @property int $weight 体重 kg
 * @property int $neuter 是否绝育
 * @property string $size 宠物尺寸大小
 * @property string $color 花色
 * @property string $createTime 创建时间
 * @property string $updateTime 更新时间
 */
class Pet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['petId'], 'required'],
            [['petId', 'status', 'gender', 'age', 'vaccineStatus', 'petType', 'weight', 'neuter'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['nickname', 'subtype'], 'string', 'max' => 16],
            [['size', 'color'], 'string', 'max' => 64],
            [['petId'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'petId' => 'Pet ID',
            'status' => 'Status',
            'nickname' => '昵称',
            'gender' => '性别',
            'age' => '年龄',
            'vaccineStatus' => '疫苗状态',
            'petType' => '宠物类别',
            'subtype' => '宠物品类',
            'weight' => '体重 kg',
            'neuter' => '是否绝育',
            'size' => '宠物尺寸大小',
            'color' => '花色',
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['petId']
                ],
                'idType' => GenerateIdBehavior::PET_ID_TYPE
            ]
        ];
    }

    /**
     * {@inheritdoc}
     * @return PetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PetQuery(get_called_class());
    }
}
