<?php


namespace app\assets;


use yii\web\AssetBundle;


class SPAAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '/';

    public $css = [
        'css/1.app.css',
        'css/app.css'
    ];

    public $js = [
        'js/1.app.js',
        'js/app.js'
    ];
}