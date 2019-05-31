<?php

use app\rbac\OrganizerRule;
use yii\db\Migration;

/**
 * Class m190531_063402_init_rbac
 */
class m190531_063402_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // 添加规则
        $organizerRule = new OrganizerRule();
        $auth->add($organizerRule);

        // 添加 创建活动 权限
        $createActivity = $auth->createPermission('createActivity');
        $createActivity->description = '创建活动';
        $auth->add($createActivity);

        // 添加 审核活动 权限
        $reviewActivity = $auth->createPermission('reviewActivity');
        $reviewActivity->description = '审核活动';
        $auth->add($reviewActivity);

        // 添加 更新活动 权限
        $updateActivity = $auth->createPermission('updateActivity');
        $updateActivity->description = '更新活动';
        $updateActivity->ruleName = $organizerRule->name;
        $auth->add($updateActivity);

        // 添加 活动创建者 角色
        $organizerRole = $auth->createRole('organizer');
        $auth->add($organizerRole);
        $auth->addChild($organizerRole, $createActivity);
        $auth->addChild($organizerRole, $updateActivity);

        // 添加 管理员 角色
        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);
        $auth->addChild($adminRole, $reviewActivity);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190531_063402_init_rbac cannot be reverted.\n";

        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190531_063402_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
