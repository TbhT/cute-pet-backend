<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banner}}`.
 */
class m190531_090259_create_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banner}}', [
            'bannerId' => $this->bigInteger()->unsigned()->unique(),
            'image' => $this->string(512)->defaultValue(''),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()'),
            'PRIMARY KEY(bannerId)'
        ]);

        $this->createIndex('idx-banner-bannerId', '{{%banner}}', 'bannerId');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-banner-bannerId', '{{%banner}}');

        $this->dropTable('{{%banner}}');
    }
}
