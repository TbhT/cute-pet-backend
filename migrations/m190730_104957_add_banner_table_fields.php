<?php

use yii\db\Migration;

/**
 * Class m190730_104957_add_banner_table_fields
 */
class m190730_104957_add_banner_table_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%banner}}', 'name', $this->string(64)->comment('轮播图名称'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%banner}}', 'name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190730_104957_add_banner_table_fields cannot be reverted.\n";

        return false;
    }
    */
}
