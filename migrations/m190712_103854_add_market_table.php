<?php

use yii\db\Migration;

/**
 * Class m190712_103854_add_market_table
 */
class m190712_103854_add_market_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%market}}', [
            'marketId' => $this->bigInteger(64)->unsigned(),
            'userId' => $this->bigInteger(64)->unsigned(),
            'status' => $this->tinyInteger(1)->unsigned(),
            'name' => $this->string(256)->comment('商家名称'),
            'contact' => $this->string(64)->comment('联系人'),
            'phone' => $this->string(64)->comment('联系方式'),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('创建时间'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('更新时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%market}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190712_103854_add_market_table cannot be reverted.\n";

        return false;
    }
    */
}
