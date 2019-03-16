<?php

namespace tests\unit\models;

use app\models\UserIdentity;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        expect_that($user = UserIdentity::findIdentity(100));
        expect($user->username)->equals('admin');

        expect_not(UserIdentity::findIdentity(999));
    }

    public function testFindUserByAccessToken()
    {
        expect_that($user = UserIdentity::findIdentityByAccessToken('100-token'));
        expect($user->username)->equals('admin');

        expect_not(UserIdentity::findIdentityByAccessToken('non-existing'));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = UserIdentity::findByUsername('admin'));
        expect_not(UserIdentity::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = UserIdentity::findByUsername('admin');
        expect_that($user->validateAuthKey('test100key'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('admin'));
        expect_not($user->validatePassword('123456'));        
    }

}
