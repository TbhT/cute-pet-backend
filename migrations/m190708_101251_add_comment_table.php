<?php

use yii\db\Migration;

/**
 * Class m190708_101251_add_comment_table
 */
class m190708_101251_add_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'commentId' => $this->bigInteger(64)->notNull()->unique()->unsigned()->comment('评论id'),
            'tweetId' => $this->bigInteger(64)->notNull()->unsigned()->comment('动态id'),
            'userId' => $this->bigInteger(64)->notNull()->unsigned()->comment('用户id'),
            'status' => $this->tinyInteger(16)->defaultValue(0)->comment('评论状态'),
            'text' => $this->string(250)->defaultValue('')->comment('评论'),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('创建时间'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('更新时间'),
            'PRIMARY KEY(commentId)'
        ]);

        $this->createIndex('idx-comment-commentId', 'comment', 'commentId');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}