<?php


namespace app\utils;


class Generate
{
    private static function timeId()
    {
        return microtime(true) * 10000;
    }

    public static function userId()
    {
        $time = self::timeId();
        return "9$time";
    }

    public static function petId()
    {
        $time = self::timeId();
        return "8$time";
    }

    private static function shortId()
    {
        $id = time();
        return "$id";
    }

    public static function marketId()
    {
        $id = self::shortId();
        return "6$id";
    }

    public static function orderId()
    {
        $id = self::timeId();
        return "1{$id}";
    }

    public static function tweetId()
    {
        $id = self::shortId();
        return "2$id";
    }

    public static function activityId()
    {
        $id = self::shortId();
        return "3$id";
    }

    public static function commentId()
    {
        $id = self::shortId();
        return "4$id";
    }

    public static function likeTweetId()
    {
        $id = self::shortId();
        return "5$id";
    }

    public static function validateCodeId()
    {
        $id = random_int(1000, 9999);
        $id = $id . '' . random_int(10, 99);
        return "$id";
    }


}