<?php

use yii\db\Migration;

/**
 * Class m190608_131340_add_topic_table
 */
class m190608_131340_add_topic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%topic}}', [
            'topicId' => $this->primaryKey()->unsigned(),
            'text' => $this->text()->notNull(),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
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
        echo "m190608_131340_add_topic_table cannot be reverted.\n";

        return false;
    }
    */
}
