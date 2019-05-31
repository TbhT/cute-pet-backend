<?php

namespace app\behaviors;

use yii\behaviors\AttributeBehavior;
use app\utils\Generate;
use yii\db\BaseActiveRecord;


class GenerateIdBehavior extends AttributeBehavior
{
    const USER_ID_TYPE = 'user_id';
    const TWEET_ID_TYPE = 'tweet_id';
    const ACTIVITY_ID_TYPE = 'activity_id';
    const COMMENT_ID_TYPE = 'comment_id';
    const LIKE_TWEET_ID_TYPE = 'like_tweet_id';
    const PET_ID_TYPE = 'pet_id';

    public $idType;

    protected function getValue($event)
    {
        if (empty($this->idType)) {
            throw new \Error('idType need to be defined !');
        }

        $value = null;

        switch ($this->idType) {
            case self::USER_ID_TYPE:
                {
                    $value = Generate::userId();
                    break;
                }

            case self::TWEET_ID_TYPE:
                {
                    $value = Generate::tweetId();
                    break;
                }

            case self::ACTIVITY_ID_TYPE:
                {
                    $value = Generate::activityId();
                    break;
                }

            case self::COMMENT_ID_TYPE:
                {
                    $value = Generate::commentId();
                    break;
                }

            case self::LIKE_TWEET_ID_TYPE:
                {
                    $value = Generate::likeTweetId();
                    break;
                }

            case self::PET_ID_TYPE:
                {
                    $value = Generate::petId();
                    break;
                }
        }

        return $value;
    }
}