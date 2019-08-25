<?php

use yii\db\Migration;

/**
 * Class m190709_031220_add_pet_table
 */
class m190709_031220_add_pet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pet}}', [
            'petId' => $this->bigInteger(64)->unique(),
            'status' => $this->tinyInteger(16)->defaultValue(0)->comment(''),
            'nickname' => $this->char(16)->comment('昵称'),
            'gender' => $this->tinyInteger(1)->comment('性别'),
            'age' => $this->tinyInteger(1)->comment('年龄'),
            'vaccineStatus' => $this->tinyInteger(1)->comment('疫苗状态'),
            'petType' => $this->tinyInteger(1)->comment('宠物类别'),
            'subtype' => $this->char(16)->comment('宠物品类'),
            'weight' => $this->integer()->comment('体重 kg'),
            'neuter' => $this->tinyInteger(1)->comment('是否绝育'),
            'size' => $this->string(64)->comment('宠物尺寸大小'),
            'color' => $this->string(64)->comment('花色'),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('创建时间'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('更新时间'),
            'PRIMARY KEY(petId)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pet}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190709_031220_add_pet_table cannot be reverted.\n";

        return false;
    }
    */
}
