<?php


namespace app\utils;


use Throwable;
use Yii;
use yii\base\Model;

class UploadImage
{
    const MATCH = '|data:image/(\w+)|';

    public static function saveImage($data, $pathName = '')
    {
        try {
            $file_array = explode(',', $data);
            preg_match(static::MATCH, $file_array[0], $image_extension);

            $webImagePath = $pathName . md5($file_array[1]) . '_' . time() . rand(1000, 9999) . '.' . $image_extension[1];
            $filename = Yii::getAlias('@webroot') . $webImagePath;

            $file = base64_decode($file_array[1]);

            if (!file_put_contents($filename, $file)) {
                Yii::error($filename);
            }
        } catch (Throwable $e) {
            $webImagePath = false;
            Yii::error($e);
        }

        return $webImagePath;
    }
}