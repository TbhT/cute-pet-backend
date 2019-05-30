<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Tweet]].
 *
 * @see Tweet
 */
class TweetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tweet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tweet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
