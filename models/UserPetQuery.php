<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserPet]].
 *
 * @see UserPet
 */
class UserPetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserPet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserPet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
