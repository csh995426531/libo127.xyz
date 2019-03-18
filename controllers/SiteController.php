<?php

namespace app\controllers;

use app\assets\AppAsset;
use app\models\SmsCode;
use app\services\SmsService;
use app\services\UserService;
use Yii;
use yii\captcha\CaptchaValidator;
use yii\filters\AccessControl;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'captcha', 'get-sms-code'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'backColor'=> 0xFFFFFF,
                'maxLength' => 5,       // 最多生成几个字符
                'minLength' => 5,       // 最少生成几个字符
//                'fixedVerifyCode' => substr(md5(time()),11,5), //每次都刷新验证码
                'height'=>40,//高度
                'width' => 90,  //宽度
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 登陆
     * @return string|Response
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if (\Yii::$app->request->isPost) {

            $params = Yii::$app->request->post('LoginForm');
            $model->setScenario($params['type']);

            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            }
        } else {

            if (!Yii::$app->user->isGuest) {//判断是否是访客

                return $this->goHome();
            }
        }

        $model->type = LoginForm::TYPE_SMS_CODE;
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * 获取手机验证码
     * @return array
     */
    public function actionGetSmsCode()
    {
        $response = ['status' => 500, 'msg' => '失败'];

        $mobile = Yii::$app->request->get('mobile');
        $verifyCode = Yii::$app->request->get('verify_code');

        try {

            if (empty($mobile)) {
                throw new \Exception('手机号不能为空');
            }

            if (empty($verifyCode)) {
                throw new \Exception('图片验证码不能为空');
            }

            $imgVerifyCode = HtmlPurifier::process($verifyCode);
            $captcha = new CaptchaValidator();
            $verifyRs = $captcha->validate($imgVerifyCode);

            if($verifyRs==false){
                throw new \Exception('图形验证码不正确');
            }

            $userService = new UserService();
            $user = $userService->findByMobile($mobile);

            if (empty($user)) {

                throw new \Exception('该手机号还未注册用户');
            }

            $smsService = new SmsService();
            $result = $smsService->sendCode($mobile, SmsCode::EVENT_LOGIN);

            if ($result == false) {

                throw new \Exception('验证码发送失败');
            }

            $response['status'] = 200;
            $response['msg'] = '发送成功';

        } catch (\Exception $e) {

            $response["msg"] = $e->getMessage();
        }

        return json_encode($response);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
