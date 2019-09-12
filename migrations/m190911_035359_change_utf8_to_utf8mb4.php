<?php

use yii\db\Migration;

/**
 * Class m190911_035359_change_utf8_to_utf8mb4
 */
class m190911_035359_change_utf8_to_utf8mb4 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('alter database db_cute_pet CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190911_035359_change_utf8_to_utf8mb4 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190911_035359_change_utf8_to_utf8mb4 cannot be reverted.\n";

        return false;
    }
    */
}
