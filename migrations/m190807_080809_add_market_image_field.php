<?php

use yii\db\Migration;

/**
 * Class m190807_080809_add_market_image_field
 */
class m190807_080809_add_market_image_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%market}}', 'image', $this->string(255)->comment('封面图片'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%market}}', 'image');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190807_080809_add_market_image_field cannot be reverted.\n";

        return false;
    }
    */
}
