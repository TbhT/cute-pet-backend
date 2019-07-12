<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_pet".
 *
 * @property int $id
 * @property string $petId
 * @property string $activityId
 * @property string $createTime 创建时间
 * @property string $updateTime 更新时间
 */
class ActivityPet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_pet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['petId', 'activityId'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['activityId', 'petId'], 'unique', 'targetAttribute' => ['activityId', 'petId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'petId' => 'Pet ID',
            'activityId' => 'Activity ID',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ActivityPetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActivityPetQuery(get_called_class());
    }
}
