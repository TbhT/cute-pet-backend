<?php

use yii\db\Migration;

/**
 * Class m190622_054454_add_market_intro_field
 */
class m190622_054454_add_market_intro_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%market}}', 'intro', $this->string(512)->comment('简介'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%market}}', 'intro');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190622_054454_add_market_intro_field cannot be reverted.\n";

        return false;
    }
    */
}
