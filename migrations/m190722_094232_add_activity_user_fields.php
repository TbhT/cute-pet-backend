<?php

use yii\db\Migration;

/**
 * Class m190722_094232_add_activity_user_fields
 */
class m190722_094232_add_activity_user_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%activity_user}}', 'type', $this->tinyInteger(8)->comment('支付类型'));
        $this->addColumn('{{%activity_user}}', 'amount', $this->float(2)->comment('金额'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activity_user}}', 'type');
        $this->dropColumn('{{%activity_user}}', 'amount');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190722_094232_add_activity_user_fields cannot be reverted.\n";

        return false;
    }
    */
}
