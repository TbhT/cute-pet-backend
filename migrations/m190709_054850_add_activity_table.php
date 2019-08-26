<?php

use yii\db\Migration;

/**
 * Class m190709_054850_add_activity_table
 */
class m190709_054850_add_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%activity}}', [
            'activityId' => $this->bigInteger(64)->unique(),
            'status' => $this->tinyInteger(1)->defaultValue(1)->comment('活动审核状态'),
            'name' => $this->char(32)->defaultValue('')->comment('活动名称'),
            'beginTime' => $this->dateTime()->comment('活动开始时间'),
            'endTime' => $this->dateTime()->comment('活动结束时间'),
            'joinBeginTime' => $this->dateTime()->comment('报名开始时间'),
            'joinEndTime' => $this->dateTime()->comment('报名截止时间'),
            'organizer' => $this->char(127)->defaultValue('')->comment('主办方'),
            'coorganizer' => $this->char(127)->defaultValue('')->comment('协办方'),
            'place' => $this->char(255)->defaultValue('')->comment('活动地点'),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('创建时间'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('更新时间'),
            'PRIMARY KEY(activityId)'
        ]);

        $this->createIndex('idx-activity-activityId', '{{%activity}}', 'activityId');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190709_054850_add_activity_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190709_054850_add_activity_table cannot be reverted.\n";

        return false;
    }
    */
}
