<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ActivityUser]].
 *
 * @see ActivityUser
 */
class ActivityUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ActivityUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ActivityUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
