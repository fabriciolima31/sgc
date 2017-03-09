<?php

class SessaoFormCest
{
    private $model;
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testVisualisaaoDeSessao(\FunctionalTester $I)
    {
        $I->amOnRoute('site/login');

        $I->submitForm('#login-form', [
            'LoginForm[cpf]' => '156.229.772-40',
            'LoginForm[password]' => '123456',
        ]);

        $I->see('Pacientes - Lista de Espera', 'h1');
        $I->see('Silva Rubens de Oliveira');

        $I->amOnRoute('usuario-paciente/create&id=6');

        $I->submitForm('#w0', [
            'UsuarioPaciente[Usuario_id]]' => '2',
        ]);
        
        $I->see('Pacientes - Entrar em Contato', 'h1');

        
        $I->amOnRoute('site/logout');
        $I->amOnRoute('site/login');

        $I->submitForm('#login-form', [
            'LoginForm[cpf]' => '013.186.002-00',
            'LoginForm[password]' => '123456',
        ]);

        $I->see('Sessões Agendadas', 'h1');

        $I->see('Silva Rubens de Oliveira');
    }
}
