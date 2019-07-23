<?php

use yii\db\Migration;

/**
 * Class m190723_073701_add_city_table_index_fields
 */
class m190723_073701_add_city_table_index_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%city}}', 'pId', $this->integer()->comment('省份id'));
        $this->addColumn('{{%city}}', 'cId', $this->integer()->comment('城市id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%city}}', 'pId');
        $this->dropColumn('{{%city}}', 'cId');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190723_073701_add_city_table_index_fields cannot be reverted.\n";

        return false;
    }
    */
}
