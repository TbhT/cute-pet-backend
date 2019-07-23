<?php

use yii\db\Migration;

/**
 * Class m190723_053452_add_activity_table_count_fields
 */
class m190723_053452_add_activity_table_count_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%activity}}','personCount', $this->integer()->comment('参与总人数'));
        $this->addColumn('{{%activity}}', 'province', $this->string(16)->comment('省份'));
        $this->addColumn('{{%activity}}', 'city', $this->string(32)->comment('城市'));
        $this->addColumn('{{%activity}}', 'area', $this->string(32)->comment('区'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activity}}', 'personCount');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190723_053452_add_activity_table_count_fields cannot be reverted.\n";

        return false;
    }
    */
}
