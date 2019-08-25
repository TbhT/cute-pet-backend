<?php

use yii\db\Migration;

/**
 * Class m190709_060540_add_user_pet_table
 */
class m190709_060540_add_user_pet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_pet}}', [
            'id' => $this->primaryKey()->unique(),
            'userId' => $this->bigInteger(64)->unsigned(),
            'petId' => $this->bigInteger(64)->unsigned(),
            'status' => $this->tinyInteger(8)->unsigned()->comment('关系'),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('创建时间'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('更新时间'),
            'UNIQUE KEY (userId, petId)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_pet}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190709_060540_add_user_pet_table cannot be reverted.\n";

        return false;
    }
    */
}
