<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
use app\utils\UploadImage;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pet".
 *
 * @property string $petId
 * @property int $status
 * @property string $nickname
 * @property int $gender
 * @property int $age
 * @property int $vaccineStatus
 * @property int $petType
 * @property string $type
 * @property string $createTime
 * @property string $updateTime
 * @property bool|string image
 */
class Pet extends ActiveRecord
{
    public $picture;

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
            [['status', 'gender', 'age', 'vaccineStatus', 'petType'], 'integer'],
            [['nickname', 'type'], 'string', 'max' => 16],
            [['picture'], 'safe']
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['petId']
                ],
                'idType' => GenerateIdBehavior::PET_ID_TYPE
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'petId' => '宠物id',
            'status' => '宠物状态',
            'nickname' => '宠物昵称',
            'gender' => '性别',
            'age' => '年龄',
            'vaccineStatus' => '疫苗状态',
            'petType' => '宠物类型',
            'type' => '品种',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
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

    public function save($runValidation = true, $attributeNames = null, $path = 'images')
    {
        $webImagePath = UploadImage::saveImage($this->picture, 'images');
        $this->image = $webImagePath;
        return parent::save($runValidation, $attributeNames);
    }

}
