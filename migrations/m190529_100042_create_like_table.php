<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%like}}`.
 */
class m190529_100042_create_like_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%like_tweet}}', [
            'likeId' => $this->primaryKey()->unique(),
            'tweetId' => $this->string(127)->unique(),
            'userId' => $this->string(255)->notNull(),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'PRIMARY KEY(likeId)'
        ]);

        $this->createIndex('idx-like-tweet-likeId', '{{%like_tweet}}', 'likeId');

        $this->createIndex('idx-like-tweet-userId', '{{%like_tweet}}', 'userId');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-like-tweet-likeId', '{{%like_tweet}}');

        $this->dropIndex('idx-like-tweet-userId', '{{%like_tweet}}');

        $this->dropTable('{{%like_tweet}}');
    }
}
