<?php

use yii\db\Migration;

/**
 * Class m190807_082944_add_market_table_fields
 */
class m190807_082944_add_market_table_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%market}}', 'place', $this->string(255)->comment('地点'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%market}}', 'place');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190807_082944_add_market_table_fields cannot be reverted.\n";

        return false;
    }
    */
}
