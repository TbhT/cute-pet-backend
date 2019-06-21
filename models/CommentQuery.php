<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Comment]].
 *
 * @see Comment
 */
class CommentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * 获取评论的详情
     * @param $commentId
     * @return CommentQuery
     */
    public function commentDetail($commentId)
    {
        return $this->andOnCondition(['commentId' => $commentId]);
    }

    /**
     * 获取动态下的所有评论
     * @param $tweetId
     * @param int $offset
     * @return CommentQuery
     */
    public function getTweetAllComment($tweetId, $offset = 0)
    {
        return $this->andOnCondition(['tweetId' => $tweetId])
            ->limit(20)
            ->offset($offset);
    }
}
