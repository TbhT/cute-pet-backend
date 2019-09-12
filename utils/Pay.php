<?php


namespace app\utils;


use Error;
use Yii;
use Yurun\PaySDK\Weixin\H5\Params\Pay\Request;
use Yurun\PaySDK\Weixin\H5\Params\SceneInfo;
use Yurun\PaySDK\Weixin\Params\PublicParams;
use Yurun\PaySDK\Weixin\SDK;

class Pay
{
    public static function WeChatH5Pay($opt = [])
    {
        $params = new PublicParams;
        $params->appID = Yii::$app->params['WeChatParams']['appid'];
        $params->mch_id = Yii::$app->params['WeChatParams']['mch_id'];
        $params->key = Yii::$app->params['WeChatParams']['key'];

        $pay = new SDK($params);
        $request = new Request();
        $request->body = $opt['body'];
        $request->out_trade_no = $opt['userId'];
        $request->total_fee = $opt['totalFee'];
        $request->spbill_create_ip = $opt['clientIP'];
        $request->notify_url = Yii::$app->params['WeChatParams']['notify_url'];

        $request->scene_info = new SceneInfo();
        $request->scene_info->type = 'wap';
        $request->scene_info->wap_url = Yii::$app->params['WeChatParams']['notify_url'];
        $request->scene_info->wap_name = Yii::$app->params['WeChatParams']['wap_name'];

        $result = $pay->execute($request);
    }

    public static function JsApiPay()
    {

    }

    private static function createOAuthUrlForCode($redirectUrl)
    {
        $urlObj['appid'] = Yii::$app->params['WeChatParams']['appid'];
        $urlObj['redirect_uri'] = $redirectUrl;
        $urlObj['response_type'] = 'code';
        $urlObj['scope'] = 'snsapi_base';
        $urlObj['state'] = "STATE" . "#wechat_redirect";
        $bizString = static::ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?" . $bizString;
    }

    private static function createOAuthUrlForOpenid($code)
    {
        $urlObj['appid'] = Yii::$app->params['WeChatParams']['appid'];
        $urlObj['secret'] = Yii::$app->params['WeChatParams']['app_secret'];
        $urlObj['code'] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = static::ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?" . $bizString;
    }

    public static function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 生成签名
     * @param WxPayConfigInterface $config 配置对象
     * @return string 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public static function MakeSign($config)
    {
        //签名步骤一：按字典序排序参数
        ksort($config);
        $string = static::ToUrlParams($config);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . Yii::$app->params['WeChatParams']['key'];
        //签名步骤三：MD5加密或者HMAC-SHA256
        $signType = Yii::$app->params['WeChatParams']['sign_type'];

        if ($signType == "MD5") {
            $string = md5($string);
        } else if ($signType == "HMAC-SHA256") {
            $string = hash_hmac("sha256", $string, Yii::$app->params['WeChatParams']['key']);
        } else {
            throw new Error("签名类型不支持！");
        }

        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    public static function GetOpenid()
    {
        $code = Yii::$app->request->get('code');

        if (empty($code)) {
            //触发微信返回code码
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);
            $url = static::createOAuthUrlForCode($baseUrl);
            Header("Location: $url");
            exit();
        } else {
            //获取code码，以获取openid
            $openid = static::GetOpenidFromMp($code);
            return $openid;
        }
    }

    public static function GetOpenidFromMp($code)
    {
        $url = static::createOAuthUrlForOpenid($code);

        //初始化curl
        $ch = curl_init();
        $curlVersion = curl_version();
        $ua = "WXPaySDK/3.0.9 (" . PHP_OS . ") PHP/" . PHP_VERSION . " CURL/" . $curlVersion['version'] . " "
            . Yii::$app->params['WeChatParams']['mch_id'];

        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $proxyHost = "0.0.0.0";
        $proxyPort = 0;
        if ($proxyHost != "0.0.0.0" && $proxyPort != 0) {
            curl_setopt($ch, CURLOPT_PROXY, $proxyHost);
            curl_setopt($ch, CURLOPT_PROXYPORT, $proxyPort);
        }
        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);
        //取出openid
        $data = json_decode($res, true);
        $openid = $data['openid'];
        return $openid;
    }

    private static function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v) {
            if ($k != "sign") {
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

}