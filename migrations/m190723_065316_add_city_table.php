<?php

use yii\db\Migration;

/**
 * Class m190723_065316_add_city_table
 */
class m190723_065316_add_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey()->unsigned(),
            'province' => $this->string(16)->comment('省份'),
            'city' => $this->string(16)->comment('城市'),
            'area' => $this->string(32)->comment('区'),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('创建时间'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('更新时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%city}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190723_065316_add_city_table cannot be reverted.\n";

        return false;
    }
    */
}
