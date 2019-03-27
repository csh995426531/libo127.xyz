<?php
/**
 * Created by PhpStorm.
 * User: csh
 * Date: 2019/3/19
 * Time: 0:14
 */
namespace app\controllers;

use app\services\UserService;
use Yii;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
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

    public function actionIndex()
    {
        $userId = Yii::$app->user->getId();

        $userService = new UserService();

        $user = $userService->get($userId);

        return $this->render('index', [
            'user' => $user,
        ]);
    }
}