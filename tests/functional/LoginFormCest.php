<?php
class LoginFormCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Autenticação', 'h1');

    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('cpf cannot be blank.');
        $I->see('senha cannot be blank.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[cpf]' => '181.301.929-00',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('CPF ou Senha incorretos.');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[cpf]' => '013.186.002-00',
            'LoginForm[password]' => '123456',
        ]);
        $I->see('Logout (013.186.002-00)');
        $I->dontSeeElement('form#login-form');              
    }
}