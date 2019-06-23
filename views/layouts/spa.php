<?php
/* @var $content string */

use app\assets\SPAAsset;

SPAAsset::register($this);

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8"/>
        <meta
                http-equiv="Content-Security-Policy"
                content="default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: gap: content:"
        />
        <meta
                name="viewport"
                content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no,minimal-ui,viewport-fit=cover"
        />
        <meta name="theme-color" content="#f7b453"/>
        <meta name="format-detection" content="telephone=no"/>
        <meta name="msapplication-tap-highlight" content="no"/>
        <title>CutePet</title>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta
                name="apple-mobile-web-app-status-bar-style"
                content="black-translucent"
        />
        <link rel="apple-touch-icon" href="static/icons/apple-touch-icon.png"/>
        <link rel="icon" href="static/icons/favicon.png"/>
        <link rel="manifest" href="/manifest.json"/>
        <link href="css/1.app.css" rel="stylesheet"/>
        <link href="css/app.css" rel="stylesheet"/>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <?= $content ?>

    <!-- built script files will be auto injected -->
    <script src="1.app.js"></script>
    <script src="app.js"></script>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>