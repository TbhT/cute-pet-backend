<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_pet}}`.
 */
class m190603_142036_create_user_pet_table extends Migration
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
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
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
}
