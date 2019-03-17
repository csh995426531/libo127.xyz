<?php
/**
 * Created by PhpStorm.
 * User: csh
 * Date: 2019/3/17
 * Time: 13:52
 */
namespace app\services;

use app\models\SmsCode;

class SmsService
{
    use ErrorTrait;

    /**
     * 验证验证码
     * @param $userId
     * @param $event
     * @param $code
     * @return bool
     */
    public function validateSmsCode($userId, $event, $code)
    {
        $code = SmsCode::find()->where([
            'user_id' => $userId,
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
    }

    /**
     * 发送
     */
    public function send($mobile, $event)
    {

        if (in_array($event, [SmsCode::EVENT_REGISTER, SmsCode::EVENT_LOGIN])) {

            $template = '';

        } else {

            $this->setError(Exceptions::SMS_CODE_EVENT_ERR_CODE, '事件错误');
            return false;
        }
    }
}