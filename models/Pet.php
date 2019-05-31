<?php

namespace app\models;

use app\behaviors\GenerateIdBehavior;
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
 */
class Pet extends ActiveRecord
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
            [['status', 'gender', 'age', 'vaccineStatus', 'petType'], 'integer'],
            [['nickname', 'type'], 'string', 'max' => 16],
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
            'petId' => 'Pet ID',
            'status' => 'Status',
            'nickname' => 'Nickname',
            'gender' => 'Gender',
            'age' => 'Age',
            'vaccineStatus' => 'Vaccine Status',
            'petType' => 'Pet Type',
            'type' => 'Type',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
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
