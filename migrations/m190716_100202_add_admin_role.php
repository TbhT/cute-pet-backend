<?php

use yii\db\Migration;

/**
 * Class m190716_100202_add_admin_role
 */
class m190716_100202_add_admin_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // 添加管理员角色
        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190716_100202_add_admin_role cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190716_100202_add_admin_role cannot be reverted.\n";

        return false;
    }
    */
}
