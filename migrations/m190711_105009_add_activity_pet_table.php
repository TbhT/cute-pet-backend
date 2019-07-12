<?php

use yii\db\Migration;

/**
 * Class m190711_105009_add_activity_pet_table
 */
class m190711_105009_add_activity_pet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%activity_pet}}', [
            'id' => $this->primaryKey()->unique(),
            'petId' => $this->bigInteger(64)->unsigned(),
            'activityId' => $this->bigInteger(64)->unsigned(),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('创建时间'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('更新时间'),
            'UNIQUE KEY (activityId, petId)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%activity_pet}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190711_105009_add_activity_pet_table cannot be reverted.\n";

        return false;
    }
    */
}
