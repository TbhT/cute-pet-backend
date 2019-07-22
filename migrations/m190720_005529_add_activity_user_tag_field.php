<?php

use yii\db\Migration;

/**
 * Class m190720_005529_add_activity_user_tag_field
 */
class m190720_005529_add_activity_user_tag_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%activity_user}}', 'tag', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activity_user}}', 'tag');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190720_005529_add_activity_user_tag_field cannot be reverted.\n";

        return false;
    }
    */
}
