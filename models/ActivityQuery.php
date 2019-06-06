<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Activity]].
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
     * 获取活动详情
     * @param $activityId
     * @return ActivityQuery
     */
    public function getDetail($activityId)
    {
        return $this->andOnCondition(['activityId' => $activityId]);
    }

    /**
     * 获取某类型的活动
     * @param $type
     * @return ActivityQuery
     */
    public function getActivities($type)
    {
        return $this->andOnCondition(['type' => $type]);
    }
}
