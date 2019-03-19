<?php
/**
 * Created by PhpStorm.
 * User: csh
 * Date: 2019/3/17
 * Time: 13:52
 */
namespace app\services;

use app\models\SmsCode;
use Yii;
use Yunpian\Sdk\YunpianClient;

class SmsService
{
    use ErrorTrait;

    /**
     * 验证验证码
     * @param $mobile
     * @param $event
     * @param $code
     * @return bool
     */
    public function validateSmsCode($mobile, $event, $code)
    {
        $code = SmsCode::find()->where([
            'mobile' => $mobile,
            'event' => $event,
            'code' => $code
        ])->orderBy(['id' => SORT_DESC])->one();

        if (empty($code)) {

            $this->setError(Exceptions::SMS_CODE_NOT_EXISTS_ERR_CODE, '验证码错误');
            return false;
        }

        if ($code->create_time < (time() - 600)) { //验证码超过10分钟

            $this->setError(Exceptions::SMS_CODE_TIME_OUT_ERR_CODE, '验证码错误');
            return false;
        }

        return true;
    }

    /**
     * 创建验证码记录
     * @param $mobile
     * @param $event
     * @param $code
     * @return bool
     */
    private function createSmsCodeHistory($mobile, $event, $code)
    {
        $model = new SmsCode();
        $model->mobile = $mobile;
        $model->event = $event;
        $model->code = (string)$code;
        $model->status = SmsCode::STATUS_NOT_USED;
        $model->create_time = time();
        $model->update_time = time();

        return $model->save();
    }

    /**
     * 生成验证码
     * @return int
     */
    private function generateCode()
    {
        return mt_rand(100000, 999999);
    }

    /**
     * 发送验证码
     * @param $mobile
     * @param $event
     * @return bool
     */
    public function sendCode($mobile, $event)
    {

        $code = $this->generateCode();

        if ($this->createSmsCodeHistory($mobile, $event, $code) == false){

            $result = false;
        } else {

            if (in_array($event, [SmsCode::EVENT_REGISTER, SmsCode::EVENT_LOGIN])) {

                $text = "【达拉崩吧浩然】您的验证码是{$code}。如非本人操作，请忽略本短信";

            } else {

                $this->setError(Exceptions::SMS_CODE_EVENT_ERR_CODE, '事件错误');
                return false;
            }

            $result = $this->send($text, $mobile);
        }

        return $result;
    }

    /**
     * 发送短信
     * @param $text
     * @param $mobile
     * @return bool
     */
    private function send($text, $mobile)
    {return true;
        //初始化client,apikey作为所有请求的默认值
        $client = YunpianClient::create(Yii::$app->params['fc00da8167ef4712267ae1d92afe7261']);

        $param = [YunpianClient::MOBILE => $mobile, YunpianClient::TEXT => $text];
        $r = $client->sms()->single_send($param);

        if($r->isSucc()){
            return true;
            //$r->data()
        } else {
            return false;
        }
    }

}