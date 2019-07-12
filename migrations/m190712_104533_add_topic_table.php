<?php

use yii\db\Migration;

/**
 * Class m190712_104533_add_topic_table
 */
class m190712_104533_add_topic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%topic}}', [
            'topicId' => $this->primaryKey()->unsigned(),
            'text' => $this->string(255)->defaultValue('')->comment('话题文本'),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('创建时间'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('更新时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%topic}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190712_104533_add_topic_table cannot be reverted.\n";

        return false;
    }
    */
}
