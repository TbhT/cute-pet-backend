<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Pet]].
 *
 * @see Pet
 */
class PetQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Pet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Pet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $petId
     * @return PetQuery
     */
    public function getPetDetail($petId)
    {
        return $this->andOnCondition(['petId' => $petId]);
    }

    /**
     * @param $userId
     * @return PetQuery
     */
    public function getAllPersonPets($userId)
    {
        return $this->andOnCondition(['userId' => $userId]);
    }
}
