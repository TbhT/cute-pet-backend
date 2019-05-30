<?php

namespace app\models;

use Yii;
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
            [['status', 'gender', 'age', 'vaccineStatus', 'petType'], 'integer'],
            [['petId'], 'string', 'max' => 255],
            [['nickname', 'type'], 'string', 'max' => 16],
            [['petId'], 'unique'],
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
