<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>宠伢</title>
    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
    <script src="/js/vconsole.min.js"></script>

    <script type="text/javascript">
        new VConsole();

        //调用微信JS api 支付
        var orderId = <?= $orderId ?>;

        function jsApiCall() {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?= $jsApiParameters; ?>,
                function (res) {
                    // if (res.err_msg == "get_brand_wcpay_request:ok") {
                        $.ajax({
                            url: '/order/j-final',
                            data: {orderId: orderId},
                            success: function (data) {
                                console.log(data)
                            }
                        })
                    // } else {
                    //     alert('未支付成功')
                    //     setTimeout(function () {
                    //         location.href = '/'
                    //     }, 1000)
                    // }
                }
            );
        }

        function callpay() {
            if (typeof WeixinJSBridge == "undefined") {
                if (document.addEventListener) {
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                } else if (document.attachEvent) {
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            } else {
                jsApiCall();
            }
        }

        callpay();
    </script>
</head>
<body>
</body>
</html>