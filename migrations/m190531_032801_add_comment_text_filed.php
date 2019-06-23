<?php

use yii\db\Migration;

/**
 * Class m190531_032801_add_comment_text_filed
 */
class m190531_032801_add_comment_text_filed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%comment}}', 'text', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%comment}}', 'text');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190531_032801_add_comment_text_filed cannot be reverted.\n";

        return false;
    }
    */
}
