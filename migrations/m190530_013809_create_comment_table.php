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
            'commentId' => $this->integer(32),
            'tweetId' => $this->integer(32),
            'userId' => $this->string(255)->notNull(),
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
