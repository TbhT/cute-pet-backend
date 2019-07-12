<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ActivityPet]].
 *
 * @see ActivityPet
 */
class ActivityPetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ActivityPet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ActivityPet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
