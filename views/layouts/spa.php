<?php
/* @var $content string */

use app\assets\SPAAsset;

SPAAsset::register($this);

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <!--
        Customize this policy to fit your own app's needs. For more guidance, see:
            https://github.com/apache/cordova-plugin-whitelist/blob/master/README.md#content-security-policy
        Some notes:
          * gap: is required only on iOS (when using UIWebView) and is needed for JS->native communication
          * https://ssl.gstatic.com is required only on Android and is needed for TalkBack to function properly
          * Disables use of inline scripts in order to mitigate risk of XSS vulnerabilities. To change this:
            * Enable inline JS: add 'unsafe-inline' to default-src
        -->
        <meta http-equiv="Content-Security-Policy"
              content="default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: gap: content:">
        <meta name="viewport"
              content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui, viewport-fit=cover">

        <meta name="theme-color" content="#f7b453">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <title>CutePet</title>

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <link rel="apple-touch-icon" href="static/icons/apple-touch-icon.png">
        <link rel="icon" href="static/icons/favicon.png">
        <link rel="manifest" href="/manifest.json">

        <!-- built styles file will be auto injected -->
    </head>

    <body>
    <?php $this->beginBody() ?>
    <?= $content ?>

    <!-- built script files will be auto injected -->
    <script type="text/javascript" src="vendors~main.app.js"></script>
    <script type="text/javascript" src="app.js"></script>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>