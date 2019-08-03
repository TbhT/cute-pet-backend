<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class UploadForm extends Model
{
    public $imageFile;
    public $path;

    public function rules()
    {
        return [
            [
                ['imageFile'], 'image', 'skipOnEmpty' => true
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'imageFile' => '封面图片'
        ];
    }

    public function upload($path = 'images')
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        if (!$this->imageFile) {
            return true;
        }

        if ($this->validate()) {
            $webPath = '/' . $path . '/' .
                md5($this->imageFile->baseName) . time() . rand(1000, 9999) .
                '.' . $this->imageFile->extension;

            $path = Yii::getAlias('@webroot') . $webPath;

            $this->imageFile->saveAs($path);
            $this->path = $webPath;
            return true;
        } else {
            return false;
        }
    }
}