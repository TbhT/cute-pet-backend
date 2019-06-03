<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Tweet]].
 *
 * @see Tweet
 */
class TweetQuery extends ActiveQuery
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

    /**
     * 获取用户的所有推特
     * @param null $userId
     * @param int $num
     * @param int $offset
     * @return TweetQuery
     */
    public function tweetsByUserId($userId, $num = 20, $offset = 0)
    {
        return $this->andOnCondition(['userId' => $userId])
            ->limit($num)
            ->offset($offset);
    }

    /**
     * 获取推特详情, 包含用户头像
     * @param $tweetId
     * @return TweetQuery
     */
    public function tweetDetail($tweetId)
    {
        return $this->andOnCondition(['tweetId' => $tweetId])
            ->innerJoinWith('user');
    }

    /**
     * 获取推特下的所有评论信息
     * @param $tweetId
     * @return TweetQuery
     */
    public function comments($tweetId)
    {
        return $this->andOnCondition(['tweetId' => $tweetId])
            ->innerJoinWith('comments')
            ->innerJoinWith('user');
    }
}
