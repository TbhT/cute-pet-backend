<?php

use yii\db\Migration;

/**
 * Class m190824_051849_add_pet_field
 */
class m190824_051849_add_pet_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%pet}}', 'avatar', $this->string(255)->comment('头像'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%pet}}', 'avatar');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190824_051849_add_pet_field cannot be reverted.\n";

        return false;
    }
    */
}
