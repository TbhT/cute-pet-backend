<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pet}}`.
 */
class m190530_015536_create_pet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pet}}', [
            'petId' => $this->bigInteger(64)->unique(),
            'status' => $this->tinyInteger(16)->defaultValue(0),
            'nickname' => $this->char(16),
            'gender' => $this->tinyInteger(1),
            'age' => $this->tinyInteger(1),
            'vaccineStatus' => $this->tinyInteger(1),
            'petType' => $this->tinyInteger(1),
            'type' => $this->char(16),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'PRIMARY KEY(petId)'
        ]);

        $this->createIndex('idx-pet-petId', '{{%pet}}', 'petId');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pet}}');
    }
}
