<?php
/**
 * Created by PhpStorm.
 * User: csh
 * Date: 2019/3/17
 * Time: 0:58
 */
namespace app\services;

use app\models\User;

class UserService
{
    public function create($mobile)
    {
        $model = new User();
        $model->user_name = 'lb_' . $mobile;
        $model->password = '';
        $model->auth_key = \Yii::$app->security->generateRandomString();
        $model->access_token = \Yii::$app->security->generateRandomString();
        $model->mobile = $model;
        $model->status = User::STATUS_ACTIVE;
        $model->create_time = time();
        $model->update_time = time();

        return $model->save();
    }
}