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
    /**
     * 创建用户
     * @param $mobile
     * @return bool
     * @throws \yii\base\Exception
     */
    public function create($mobile)
    {
        $model = new User();
        $model->username = 'lb_' . $mobile;
        $model->password = '';
        $model->auth_key = \Yii::$app->security->generateRandomString();
        $model->access_token = \Yii::$app->security->generateRandomString();
        $model->mobile = $mobile;
        $model->status = User::STATUS_ACTIVE;
        $model->create_time = time();
        $model->update_time = time();

        return $model->save();
    }

    /**
     * 获取用户
     * @param $userId
     * @return null|static
     */
    public function get($userId)
    {
        return User::findOne($userId);
    }

    /**
     * 根据手机号查询用户
     * @param $mobile
     * @return null|static
     */
    public function findByMobile($mobile)
    {
        return User::findOne(['mobile' => $mobile]);
    }

}