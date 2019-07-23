<?php

use yii\db\Migration;

/**
 * Class m190723_032106_add_activity_table_price_fields
 */
class m190723_032106_add_activity_table_price_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%activity}}', 'personUnitPrice', $this->float(2)->comment('人单价'));
        $this->addColumn('{{%activity}}', 'petUnitPrice', $this->float(2)->comment('宠单价'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activity}}', 'personUnitPrice');
        $this->dropColumn('{{%activity}}', 'petUnitPrice');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190723_032106_add_activity_table_price_fields cannot be reverted.\n";

        return false;
    }
    */
}
