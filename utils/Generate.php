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
        $r = rand(1000, 9999);
        return "$r$id";
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


}