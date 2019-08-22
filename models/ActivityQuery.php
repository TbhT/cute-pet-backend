<?php

namespace app\models;


/**
 * This is the ActiveQuery class for [[ActivityPet]].
 *
 * @see Activity
 */
class ActivityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Activity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Activity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * 获取某类型的活动
     * @param $type
     * @return ActivityQuery
     */
    public function getActivities($type)
    {
        return $this->andOnCondition(['type' => $type, 'status' => Activity::PASSED]);
    }

    /**
     * 获取用户参加过的活动那个
     * @param $userId
     * @return ActivityQuery
     */
    public function getUserActivities($userId)
    {
        return $this->andOnCondition(['userId' => $userId, 'status' => Activity::PASSED]);
    }
}
