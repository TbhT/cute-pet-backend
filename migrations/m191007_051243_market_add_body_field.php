<?php

use yii\db\Migration;

/**
 * Class m191007_051243_market_add_body_field
 */
class m191007_051243_market_add_body_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%market}}', 'body', $this->text()->comment('市场详情'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%market}}', 'body');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191007_051243_market_add_body_field cannot be reverted.\n";

        return false;
    }
    */
}
