<?php

namespace app\models;

use app\services\SmsService;
use app\services\UserService;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property UserIdentity|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{

    public $mobile;
    public $smsCode;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['mobile', 'smsCode'], 'required'],
            ['smsCode', 'validateSmsCode', 'message' => '短信验证码错误'],
        ];
    }

    /**
     * 验证短信验证码
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function validateSmsCode($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $smsService = new SmsService();

            if (!$smsService->validateSmsCode($this->mobile, SmsCode::EVENT_REGISTER, $this->smsCode)) {
                $this->addError($attribute, $smsService->getMessage());
            }

            return true;
        }
    }

    /**
     * 创建用户
     * @return bool
     */
    public function create()
    {
        if ($this->validate()) {

            $service = new UserService();
            if ($service->create($this->mobile)) {

                $user = UserIdentity::findByMobile($this->mobile);

                if ($user) {

                    return Yii::$app->user->login($user, 0);
                }
            }
        }
        return false;
    }
}
