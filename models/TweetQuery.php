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
    public function getTweetsByUserId($userId, $offset = 0, $num = 20)
    {
        return $this->andOnCondition(['tweet.userId' => $userId])
            ->innerJoinWith('user')
            ->joinWith('userLikeStatus')
            ->limit($num)
            ->offset($offset);
    }

    /**
     * 获取推特详情, 包含用户头像
     * @param $tweetId
     * @return TweetQuery
     */
    public function getTweetDetail($tweetId)
    {
        return $this->andOnCondition(['tweetId' => $tweetId])
            ->innerJoinWith('user');
    }

    /**
     * 获取推特下的所有评论信息
     * @param $tweetId
     * @return TweetQuery
     */
    public function getComments($tweetId)
    {
        return $this->andOnCondition(['tweetId' => $tweetId])
            ->innerJoinWith('comments')
            ->innerJoinWith('user');
    }

    /**
     * 查询主题相关的动态信息流
     * @param $topicId
     * @return |null
     */
    public function relatedTweets($topicId)
    {
        $topic = Topic::find()->where(['topicId' => $topicId])->one();

        if (empty($topic)) {
            return $this;
        }

        return $this->andWhere([
            'like', 'text', $topic->text
        ]);
    }

    /**
     *
     * @param $userId
     * @return TweetQuery
     */
    public function likeTweetStatus($userId)
    {
       return $this->leftJoin('like_tweet', ['like_tweet.userId' => $userId])
           ->where(['userId', 'tweetId']);
    }
}
