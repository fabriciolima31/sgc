<?php
namespace tests\models;
use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(2));
        expect($user->cpf)->equals('013.186.002-00');

        expect_not(User::findIdentity(1));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('013.186.002-00'));
        expect_not(User::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByUsername('013.186.002-00');

        expect_that($user->validatePassword('123456'));
        expect_not($user->validatePassword('admin'));        
    }

}
