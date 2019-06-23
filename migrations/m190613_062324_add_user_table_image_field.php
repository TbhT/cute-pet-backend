<?php

use yii\db\Migration;

/**
 * Class m190613_062324_add_user_table_image_field
 */
class m190613_062324_add_user_table_image_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'image', $this->string(256)->comment('头像地址'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_062324_add_user_table_image_field cannot be reverted.\n";

        return false;
    }
    */
}
