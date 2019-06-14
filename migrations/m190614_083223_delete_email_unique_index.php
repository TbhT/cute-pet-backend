<?php

use yii\db\Migration;

/**
 * Class m190614_083223_delete_email_unique_index
 */
class m190614_083223_delete_email_unique_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('user_unique_email', '{{%user}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190614_083223_delete_email_unique_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190614_083223_delete_email_unique_index cannot be reverted.\n";

        return false;
    }
    */
}
