<?php


namespace app\rbac;

use yii\rbac\Item;
use yii\rbac\Rule;


class OrganizerRule extends Rule
{

    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool
     */
    public function execute($user, $item, $params)
    {
        return isset($params['activity']) ? ($params['activity']->createBy == $user) : false;
    }
}