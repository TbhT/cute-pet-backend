<?php

use yii\db\Migration;

/**
 * Class m190711_104106_add_activity_user_table
 */
class m190711_104106_add_activity_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%activity_user}}', [
            'id' => $this->primaryKey()->unique(),
            'userId' => $this->bigInteger(64)->unsigned(),
            'name' => $this->string(32)->defaultValue('')->comment('随行人姓名'),
            'phone' => $this->string(32)->defaultValue('')->comment('随行人电话'),
            'relation' => $this->string(32)->defaultValue('')->comment('随行人关系'),
            'size' => $this->string(32)->defaultValue('')->comment('随行人尺寸'),
            'activityId' => $this->bigInteger(64)->unsigned()->comment('活动id'),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'UNIQUE KEY(userId, activityId)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%activity_user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190711_104106_add_activity_user_table cannot be reverted.\n";

        return false;
    }
    */
}
