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
}
