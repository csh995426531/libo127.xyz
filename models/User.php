<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lb_user".
 *
 * @property string $id
 * @property string $user_name 昵称
 * @property string $password 密码
 * @property string $auth_key 会话令牌
 * @property string $access_token 授权令牌
 * @property string $mobile 手机号
 * @property int $status 账号状态 1:正常 2:禁用
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class User extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1; //正常
    const STATUS_INVALID = 2; //无效

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mobile', 'status', 'create_time', 'update_time'], 'integer'],
            [['user_name', 'password', 'auth_key', 'access_token'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => 'user_name',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'mobile' => 'Mobile',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
