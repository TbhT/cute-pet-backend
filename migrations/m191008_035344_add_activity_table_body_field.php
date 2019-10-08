<?php

use yii\db\Migration;

/**
 * Class m191008_035344_add_activity_table_body_field
 */
class m191008_035344_add_activity_table_body_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%activity}}', 'body', $this->text()->comment('活动详情'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activity}}', 'body');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_035344_add_activity_table_body_field cannot be reverted.\n";

        return false;
    }
    */
}
