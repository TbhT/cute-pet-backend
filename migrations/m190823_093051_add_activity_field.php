<?php

use yii\db\Migration;

/**
 * Class m190823_093051_add_activity_field
 */
class m190823_093051_add_activity_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%activity}}', 'provinceName', $this->string(255)->comment('省名'));
        $this->addColumn('{{%activity}}', 'cityName', $this->string(255)->comment('城市名'));
        $this->addColumn('{{%activity}}', 'areaName', $this->string(255)->comment('区名'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activity}}', 'provinceName');
        $this->dropColumn('{{%activity}}', 'cityName');
        $this->dropColumn('{{%activity}}', 'areaName');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190823_093051_add_activity_field cannot be reverted.\n";

        return false;
    }
    */
}
