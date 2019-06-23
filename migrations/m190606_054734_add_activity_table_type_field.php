<?php

use yii\db\Migration;

/**
 * Class m190606_054734_add_activity_table_type_field
 */
class m190606_054734_add_activity_table_type_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%activity}}',
            'type',
            $this->tinyInteger()->defaultValue(1)->comment('活动类型')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activity}}', 'type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190606_054734_add_activity_table_type_field cannot be reverted.\n";

        return false;
    }
    */
}
