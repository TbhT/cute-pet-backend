<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m190530_013809_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'commentId' => $this->bigInteger(64)->notNull()->unique()->unsigned(),
            'tweetId' => $this->bigInteger(64)->notNull()->unsigned(),
            'userId' => $this->bigInteger(64)->notNull()->unsigned(),
            'status' => $this->tinyInteger(16)->defaultValue(0),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
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
