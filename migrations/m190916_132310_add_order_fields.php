<?php

use yii\db\Migration;

/**
 * Class m190916_132310_add_order_fields
 */
class m190916_132310_add_order_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'personCount', $this->integer(11)->comment('人数'));
        $this->addColumn('{{%order}}', 'petCount', $this->integer(11)->comment('宠物数'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'personCount');
        $this->dropColumn('{{%order}}', 'petCount');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190916_132310_add_order_fields cannot be reverted.\n";

        return false;
    }
    */
}
