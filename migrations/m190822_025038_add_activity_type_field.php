<?php

use yii\db\Migration;

/**
 * Class m190822_025038_add_activity_type_field
 */
class m190822_025038_add_activity_type_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%activity}}', 'type', $this->integer(11)->comment('活动类型'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activity}}', 'type');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190822_025038_add_activity_type_field cannot be reverted.\n";

        return false;
    }
    */
}
