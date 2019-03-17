<?php
/**
 * Created by PhpStorm.
 * User: csh
 * Date: 2019/3/17
 * Time: 13:54
 */
namespace app\services;

trait SingleTrait
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {

            self::$instance = new static();
        }
        return self::$instance;
    }

}