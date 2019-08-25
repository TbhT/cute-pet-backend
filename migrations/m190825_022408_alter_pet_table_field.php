<?php

use yii\db\Migration;

/**
 * Class m190825_022408_alter_pet_table_field
 */
class m190825_022408_alter_pet_table_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%pet}}', 'petType', $this->string(255));
        $this->alterColumn('{{%pet}}', 'subType', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190825_022408_alter_pet_table_field cannot be reverted.\n";

        return false;
    }
    */
}
