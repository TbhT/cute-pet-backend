<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AreaCode]].
 *
 * @see AreaCode
 */
class AreaCodeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AreaCode[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AreaCode|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
