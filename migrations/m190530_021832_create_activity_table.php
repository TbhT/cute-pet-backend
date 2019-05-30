<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%activity}}`.
 */
class m190530_021832_create_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%activity}}', [
            'activityId' => $this->string(255)->unique(),
            'status' => $this->tinyInteger(1)->defaultValue(1),
            'name' => $this->char(32)->defaultValue(''),
            'beginTime' => $this->dateTime(),
            'endTime' => $this->dateTime(),
            'joinBeginTime' => $this->dateTime(),
            'joinEndTime' => $this->dateTime(),
            'organizer' => $this->char(127)->defaultValue(''),
            'coorganizer' => $this->char(127)->defaultValue(''),
            'place' => $this->char(255)->defaultValue(''),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'PRIMARY KEY(activityId)'
        ]);

        $this->createIndex('idx-activity-activityId', '{{%activity}}', 'activityId');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%activity}}');
    }
}
