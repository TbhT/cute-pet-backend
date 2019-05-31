<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tweet}}`.
 */
class m190529_091849_create_tweet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tweet}}', [
            'tweetId' => $this->bigInteger(64)->unsigned()->unique(),
            'userId' => $this->bigInteger(64)->unsigned()->notNull(),
            'status' => $this->tinyInteger(16)->defaultValue(0),
            'text' => $this->text()->defaultValue('')->notNull(),
            'image' => $this->string(512)->defaultValue(''),
            'commentCount' => $this->integer(11)->defaultValue(0),
            'likeCount' => $this->integer(11)->defaultValue(0),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'PRIMARY KEY(tweetId)'
        ]);

        $this->createIndex('idx-tweet-tweetId', '{{%tweet}}', 'tweetId');

        $this->createIndex('idx-tweet-userId', '{{%tweet}}', 'userId');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-tweet-tweetId', '{{%tweet}}');

        $this->dropIndex('idx-tweet-userId', '{{%tweet}}');

        $this->dropTable('{{%tweet}}');
    }
}
