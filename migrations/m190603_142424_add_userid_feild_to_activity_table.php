<?php

use yii\db\Migration;

/**
 * Class m190603_142424_add_userid_feild_to_activity_table
 */
class m190603_142424_add_userid_feild_to_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%activity}}',
            'userId',
            $this->bigInteger(64)->unsigned()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190603_142424_add_userid_feild_to_activity_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190603_142424_add_userid_feild_to_activity_table cannot be reverted.\n";

        return false;
    }
    */
}
