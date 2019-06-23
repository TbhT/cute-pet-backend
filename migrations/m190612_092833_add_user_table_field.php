<?php

use yii\db\Migration;

/**
 * Class m190612_092833_add_user_table_field
 */
class m190612_092833_add_user_table_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'name', $this->string(64)->comment('姓名'));
        $this->addColumn('{{%user}}', 'nickname', $this->string(64)->comment('昵称'));
        $this->addColumn('{{%user}}', 'gender', $this->tinyInteger()->comment('性别'));
        $this->addColumn('{{%user}}', 'age', $this->tinyInteger(8));
        $this->addColumn('{{%user}}', 'homeAddress', $this->text());
        $this->addColumn('{{%user}}', 'workAddress', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'name');
        $this->dropColumn('{{%user}}', 'nickname');
        $this->dropColumn('{{%user}}', 'gender');
        $this->dropColumn('{{%user}}', 'age');
        $this->dropColumn('{{%user}}', 'homeAddress');
        $this->dropColumn('{{%user}}', 'workAddress');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190612_092833_add_user_table_field cannot be reverted.\n";

        return false;
    }
    */
}
