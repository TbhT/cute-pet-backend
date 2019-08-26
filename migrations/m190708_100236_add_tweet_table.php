<?php

use yii\db\Migration;

/**
 * Class m190708_100236_add_tweet_table
 */
class m190708_100236_add_tweet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tweet}}', [
            'tweetId' => $this->bigInteger(64)->unsigned()->unique()->comment('推特id'),
            'userId' => $this->bigInteger(64)->unsigned()->notNull()->comment('用戶id'),
            'status' => $this->tinyInteger(16)->defaultValue(0)->comment('推特状态'),
            'text' => $this->text()->notNull()->comment('动态文本'),
            'image' => $this->string(512)->defaultValue('')->comment('动态图片url'),
            'commentCount' => $this->integer(11)->defaultValue(0)->comment('评论数量'),
            'likeCount' => $this->integer(11)->defaultValue(0)->comment('赞数量'),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('创建时间'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('更新时间'),
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
        $this->dropTable('{{%tweet}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190708_100236_add_tweet_table cannot be reverted.\n";

        return false;
    }
    */
}
