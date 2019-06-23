<?php

use yii\db\Migration;

/**
 * Class m190605_032411_add_activity_user_table
 */
class m190605_032411_add_activity_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%activity_user}}', [
            'auId' => $this->primaryKey()->unsigned(),
            'activityId' => $this->bigInteger(64)->notNull()->comment('活动id'),
            'userId' => $this->bigInteger(64)->notNull()->comment('用户id'),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
        ]);

        $this->createIndex('idx-activity-user', '{{%activity_user}}', ['activityId', 'userId']);

        $this->createIndex('idx-activity', '{{%activity_user}}', 'activityId');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190605_032411_add_activity_user_table cannot be reverted.\n";

        $this->dropIndex('idx-activity-user', '{{%activity_user}}');

        $this->dropIndex('idx-activity', '{{%activity_user}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190605_032411_add_activity_user_table cannot be reverted.\n";

        return false;
    }
    */
}
