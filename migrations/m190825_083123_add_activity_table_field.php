<?php

use yii\db\Migration;

/**
 * Class m190825_083123_add_activity_table_field
 */
class m190825_083123_add_activity_table_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%activity}}', 'tag', $this->string(255)->comment('必填字段'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activity}}', 'tag');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190825_083123_add_activity_table_field cannot be reverted.\n";

        return false;
    }
    */
}
