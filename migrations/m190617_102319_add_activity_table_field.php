<?php

use yii\db\Migration;

/**
 * Class m190617_102319_add_activity_table_field
 */
class m190617_102319_add_activity_table_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%activity}}', 'totalCount', $this->integer()->comment('活动总人数')->defaultValue(0));
        $this->addColumn('{{%activity}}', 'totalCost', $this->float(2)->comment('总费用')->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activity}}', 'totalCount');
        $this->dropColumn('{{%activity}}', 'totalCost');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190617_102319_add_activity_table_field cannot be reverted.\n";

        return false;
    }
    */
}
