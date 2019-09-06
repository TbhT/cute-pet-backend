<?php

use yii\db\Migration;

/**
 * Class m190829_082556_change_pet_table_field
 */
class m190829_082556_change_pet_table_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%pet}}', 'weight', $this->float(2)->comment('体重'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190829_082556_change_pet_table_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190829_082556_change_pet_table_field cannot be reverted.\n";

        return false;
    }
    */
}
