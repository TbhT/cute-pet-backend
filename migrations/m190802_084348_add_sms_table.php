<?php

use yii\db\Migration;

/**
 * Class m190802_084348_add_sms_table
 */
class m190802_084348_add_sms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sms}}', [
            'id' => $this->primaryKey()->unsigned()->unique(),
            'phoneNumber' => $this->string(32),
            'code' => $this->string(255),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('创建时间'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('更新时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190802_084348_add_sms_table cannot be reverted.\n";

        return false;
    }
    */
}
