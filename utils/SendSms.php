<?php


namespace app\utils;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use app\models\Sms;
use Yii;


class SendSms
{
    private static $accessKeyId = 'LTAIt5uabysIPkBI';

    private static $accessKeySecret = 'CU9qq3FDpzVjmtvOEVEc0CnFmsrQhZ';

    private static $templateCode = 'SMS_171935250';

    public static function send($phoneNumber)
    {
        $result = false;

        try {
            AlibabaCloud::accessKeyClient(static::$accessKeyId, static::$accessKeySecret)
                ->regionId('cn-hangzhou')
                ->asDefaultClient();

            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
            ->version('2017-05-25')
            ->action('SendSms')
            ->method('POST')
            ->host('dysmsapi.aliyuncs.com')
            ->options([
                'query' => [
                    'RegionId' => 'default',
                    'PhoneNumbers' => $phoneNumber,
                    'TemplateCode' => static::$templateCode
                ]
            ])
            ->request();

            if ($result->Code === 'OK') {
                $model = new Sms();
                $model->phoneNumber = $phoneNumber;
                $model->reqId = $result->RequestId;
                $model->save();
            } else {
                Yii::error($result);
                $result = false;
            }
        } catch (ClientException $e) {
            Yii::error($e->getErrorMessage());
            $result = false;
        } catch (ServerException $e) {
            Yii::error($e->getErrorMessage());
            $result = false;
        } catch (\Throwable $e) {
            Yii::error($e->getMessage());
            $result = false;
        } finally {
            return $result;
        }
    }
}