<?php

use yii\db\Migration;

/**
 * Class m190916_131032_add_order_fields
 */
class m190916_131032_add_order_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%order}}',
            'activityId',
            $this->bigInteger(64)->comment('活动id')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order}}', 'activityId');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190916_131032_add_order_fields cannot be reverted.\n";

        return false;
    }
    */
}
