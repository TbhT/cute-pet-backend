<?php

use yii\db\Migration;

/**
 * Class m190709_053538_add_banner_table
 */
class m190709_053538_add_banner_table extends Migration
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
        $this->dropTable('{{%banner}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190709_053538_add_banner_table cannot be reverted.\n";

        return false;
    }
    */
}
