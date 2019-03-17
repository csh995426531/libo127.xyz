<?php
/**
 * Created by PhpStorm.
 * User: csh
 * Date: 2019/3/17
 * Time: 14:13
 */
namespace app\services;

class Exceptions
{
    const SMS_CODE_NOT_EXISTS_ERR_CODE = 5001; //验证码不存在
    const SMS_CODE_TIME_OUT_ERR_CODE = 5002; //验证码超时

}