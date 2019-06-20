<?php


namespace app\assets;


use yii\web\AssetBundle;


class SPAAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/1.app.css',
        'app.css'
    ];

    public $js = [
        '1.app.js',
        'app.js'
    ];
}