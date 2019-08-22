<?php

use yii\db\Migration;

/**
 * Class m190822_021430_add_activity_has_join_field
 */
class m190822_021430_add_activity_has_join_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%activity}}',
            'hasJoin',
            $this->integer(11)
                ->defaultValue(0)
                ->comment('已经参加的人数')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activity}}', 'hasJoin');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190822_021430_add_activity_has_join_field cannot be reverted.\n";

        return false;
    }
    */
}
