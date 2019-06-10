<?php

use yii\db\Migration;

/**
 * Class m190610_074132_add_market_table
 */
class m190610_074132_add_market_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%market}}', [
            'marketId' => $this->bigInteger(64)->unsigned()->unique(),
            'userId' => $this->bigInteger(64)->unsigned()->notNull(),
            'status' => $this->tinyInteger(16)->defaultValue(0),
            'name' => $this->string(128)->defaultValue(''),
            'contact' => $this->char(16)->defaultValue(''),
            'phoneNumber' => $this->string(32)->defaultValue(''),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'PRIMARY KEY(marketId)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%market}}');
    }

}
