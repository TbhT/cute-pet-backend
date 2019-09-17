<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m190915_071145_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'orderId' => $this->bigInteger(64)->notNull()->unsigned()->comment('订单id'),
            'status' => $this->tinyInteger(8)->unsigned()->comment('订单状态'),
            'userId' => $this->bigInteger(64)->notNull()->unsigned()->comment('用户id'),
            'totalFee' => $this->integer(11)->notNull()->comment('订单总金额'),
            'name' => $this->string(255)->comment('商品名称'),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('创建时间'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('更新时间'),
            'PRIMARY KEY(orderId)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
