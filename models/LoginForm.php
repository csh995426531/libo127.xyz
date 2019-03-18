<?php

namespace app\models;

use app\services\SmsService;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property UserIdentity|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{

    const TYPE_PASSWORD = 'password'; //密码登陆
    const TYPE_SMS_CODE = 'sms_code'; //短信验证码登陆

    public $type;
    public $username;
    public $password;
    public $mobile;
    public $smsCode;
    public $rememberMe;
    public $verifyCode;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['type'], 'in', 'range' => [self::TYPE_PASSWORD, self::TYPE_SMS_CODE], 'message' => '登陆方式错误'],
            [['username', 'password'], 'required', 'on' => self::TYPE_PASSWORD],
            ['password', 'validatePassword'],
            [['mobile', 'smsCode'], 'required', 'on' => self::TYPE_SMS_CODE],
            ['smsCode', 'validateSmsCode'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user) {
                $this->addError($attribute, '无效的用户名或手机号.');
            } else {
                if (!$user->validatePassword($this->password)) {
                    $this->addError($attribute, '密码错误.');
                }
            }
        }
    }

    /**
     * 验证短信验证码
     * @param $attribute
     * @param $params
     */
    public function validateSmsCode($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $this->_user = UserIdentity::findByMobile($this->mobile);

            if (!$this->_user ) {
                $this->addError($attribute, '该手机号还未注册.');
            } else {
                $smsService = new SmsService();

                if (!$smsService->validateSmsCode($this->_user->mobile, SmsCode::EVENT_LOGIN, $this->smsCode)) {
                    $this->addError($attribute, $smsService->getMessage());
                }
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return UserIdentity|null
     */
    public function getUser()
    {
        if ($this->_user === false) {

            $this->_user = UserIdentity::findByMobile($this->username);

            if (empty($this->_user)) {

                $this->_user = UserIdentity::findByUsername($this->username);
            }
        }

        return $this->_user;
    }
}
