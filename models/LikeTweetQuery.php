<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[LikeTweet]].
 *
 * @see LikeTweet
 */
class LikeTweetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LikeTweet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LikeTweet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function likeDetail($likeId)
    {
        return $this->andOnCondition(['likeId' => $likeId]);
    }

    public function likeTweets($userId)
    {
        return $this->andOnCondition(['userId' => $userId]);
    }
}
