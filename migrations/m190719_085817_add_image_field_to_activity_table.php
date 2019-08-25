<?php

use yii\db\Migration;

/**
 * Class m190719_085817_add_image_field_to_activity_table
 */
class m190719_085817_add_image_field_to_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%activity}}', 'image', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activity}}', 'image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190719_085817_add_image_field_to_activity_table cannot be reverted.\n";

        return false;
    }
    */
}
