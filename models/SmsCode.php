<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lb_sms_code".
 *
 * @property string $id
 * @property string $mobile 用户id
 * @property string $event 事件
 * @property string $code 验证码
 * @property int $status 是否使用 1:未使用 2:已使用
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class SmsCode extends \yii\db\ActiveRecord
{

    const EVENT_REGISTER = 'register'; //注册
    const EVENT_LOGIN = 'login'; //登陆

    const STATUS_NOT_USED = '1'; //未使用
    const STATUS_USED= '2'; //已使用

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_sms_code';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mobile', 'status', 'create_time', 'update_time'], 'integer'],
            [['event', 'code'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => '手机号',
            'event' => 'Event',
            'code' => 'Code',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
