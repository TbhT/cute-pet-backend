<?php

use yii\db\Migration;

/**
 * Class m190708_100452_add_like_table
 */
class m190708_100452_add_like_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%like_tweet}}', [
            'likeId' => $this->bigInteger(64)->unsigned()->notNull()->unique(),
            'tweetId' => $this->bigInteger(64)->notNull()->unsigned()->comment('动态id'),
            'userId' => $this->bigInteger(64)->notNull()->unsigned()->comment('用户id'),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('创建时间'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('更新时间'),
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
        $this->dropTable('{{%like_tweet}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190708_100452_add_like_table cannot be reverted.\n";

        return false;
    }
    */
}
