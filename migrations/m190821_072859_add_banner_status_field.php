<?php

use yii\db\Migration;

/**
 * Class m190821_072859_add_banner_status_field
 */
class m190821_072859_add_banner_status_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%banner}}',
            'status',
            $this->tinyInteger(8)
                ->defaultValue(0)
                ->comment('审核状态')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%banner}}', 'status', $this->tinyInteger(8));
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190821_072859_add_banner_status_field cannot be reverted.\n";

        return false;
    }
    */
}
