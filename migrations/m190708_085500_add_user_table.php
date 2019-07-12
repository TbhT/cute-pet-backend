<?php

use yii\db\Migration;

/**
 * Class m190708_085500_add_user_table
 */
class m190708_085500_add_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'userId' => $this->bigInteger(64)->notNull()->unsigned()->comment('用户id'),
            'mobile' => $this->string(32)->defaultValue('')->comment('手机号'),
            'avatar' => $this->string(255)->defaultValue('')->comment('头像'),
            'name' => $this->string(64)->defaultValue('')->comment('名字'),
            'nickname' => $this->string(64)->defaultValue('')->comment('昵称'),
            'birth' => $this->date()->comment('出生年月日'),
            'gender' => $this->tinyInteger(8)->defaultValue(0)->comment('性别'),
            'age' => $this->tinyInteger(8)->defaultValue(0)->comment('年龄'),
            'city' => $this->string(16)->comment('城市'),
            'province' => $this->string(16)->comment('省份'),
            'address' => $this->string(120)->comment('详细地址'),
            'idCard' => $this->string(32)->comment('身份证号'),
            'high' => $this->integer()->comment('身高 cm'),
            'status' => $this->integer()->comment('用户身份状态')->defaultValue(0),
            'password_hash' => $this->string(255)->defaultValue('')->comment('密码hash'),
            'auth_key' => $this->string(255)->defaultValue('')->comment('auth_key'),
            'createTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('创建时间'),
            'updateTime' => $this->dateTime()->defaultExpression('current_timestamp()')->comment('更新时间'),
            'PRIMARY KEY(userId)',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190708_085500_add_user_table cannot be reverted.\n";

        return false;
    }
    */
}
