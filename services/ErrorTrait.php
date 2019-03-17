<?php
/**
 * Created by PhpStorm.
 * User: csh
 * Date: 2019/3/17
 * Time: 14:08
 */
namespace app\services;

Trait ErrorTrait
{
    public $errorCode = 500;
    public $errorMessage = '';


    protected function setError($code, $messge)
    {
        $this->errorCode = $code;
        $this->errorMessage = $messge;
    }

    public function getMessage()
    {
        return $this->errorMessage;
    }

    public function getCode()
    {
        return $this->errorCode;
    }
}