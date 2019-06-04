<?php

use yii\db\Migration;

/**
 * Class m190604_022348_add_user_userid_field
 */
class m190604_022348_add_user_userid_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'userId', $this->bigInteger(64)->unsigned()->comment('用户唯一标识'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'userId');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190604_022348_add_user_userid_field cannot be reverted.\n";

        return false;
    }
    */
}
