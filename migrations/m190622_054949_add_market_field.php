<?php

use yii\db\Migration;

/**
 * Class m190622_054949_add_market_field
 */
class m190622_054949_add_market_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%market}}', 'place', $this->string(512)->comment('地点'));
        $this->addColumn('{{%market}}', 'serveType', $this->tinyInteger()->comment('服务类型'));
        $this->addColumn('{{%market}}', 'workTime', $this->string(512)->comment('工作时间'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%market}}', 'place');
        $this->dropColumn('{{%market}}', 'serveType');
        $this->dropColumn('{{%market}}', 'workTime');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190622_054949_add_market_field cannot be reverted.\n";

        return false;
    }
    */
}
