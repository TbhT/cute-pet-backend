<?php

use yii\db\Migration;


/**
 * Class m190614_084909_add_image_field_activity_table
 */
class m190614_084909_add_image_field_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%activity}}', 'image', $this->string(256)->comment('活动图片'));
        $this->addColumn('{{%market}}', 'image', $this->string(256)->comment('商家图片'));
        $this->addColumn('{{%pet}}', 'image', $this->string(256)->comment('宠物头像'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activity}}', 'image');
        $this->dropColumn('{{%market}}', 'image');
        $this->dropColumn('{{%pet}}', 'image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190614_084909_add_image_field_activity_table cannot be reverted.\n";

        return false;
    }
    */
}
