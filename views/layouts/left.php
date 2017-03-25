<?php

if(!Yii::$app->user->isGuest){

    $array_de_cargos = array(1 => "Professor", 2 => "Psicólogo", 3 => "Aluno Terapeuta", 4 => "Administrativo");
    $usuario_logado = Yii::$app->user->identity;
    $nome_do_usuario = $usuario_logado->nome;
    $cargo = $usuario_logado->tipo;
}
else{
    echo "Você não está logado!";
    die;
}

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel"  style="height:60px; margin-bottom: 5%">
            <div class="info" style="left: 5px;">
                <p><b><?= $nome_do_usuario?></b></p>
                <p style="color:red; text-align: left"><?= $array_de_cargos[$cargo] ?></p>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    !Yii::$app->user->isGuest ? ['label' => 'Início', 'icon' => 'fa fa-home', 'url' => ['/site/index']]: "",
                    !Yii::$app->user->isGuest ? ['label' => 'Disciplinas', 'icon' => 'fa fa-book' ,'url' => ['/disciplina/index'], 'visible' => Yii::$app->user->identity->tipo == '4']: "",
                    !Yii::$app->user->isGuest ? ['label' => 'Consultórios', 'icon' => 'fa fa-bank' ,'url' => ['/consultorio/index'], 'visible' => Yii::$app->user->identity->tipo == '4']: "",
                    !Yii::$app->user->isGuest ? ['label' => 'Reserva de Consultório', 'icon' => 'fa fa-calendar' ,'url' => ['/agenda/index'], 'visible' => Yii::$app->user->identity->tipo != '4']: "",
                    !Yii::$app->user->isGuest ? [
                        'label' => 'Turmas',
                        'icon' => 'fa fa-graduation-cap',
                        'items' => [
                            ['label' => 'Lista de Turmas', 'icon' => 'fa fa-list', 'url' => ['/turma/index'], 'visible' => Yii::$app->user->identity->tipo == '4'],
                            ['label' => 'Alunos Alocados', 'icon' => 'fa fa-street-view', 'url' => ['/aluno-turma/index'], 'visible' => Yii::$app->user->identity->tipo == '4'],
                            ],
                        ] : "",                       
                    !Yii::$app->user->isGuest ? ['label' => 'Reserva de Consultório', 'icon' => 'fa fa-calendar' ,'url' => ['/agenda/index'], 'visible' => Yii::$app->user->identity->tipo == '4'] : "",
                    !Yii::$app->user->isGuest ? [
                        'label' => 'Listas de Pacientes',
                        'icon' => 'fa fa-users',
                        'items' => [
                            ['label' => 'Lista de Espera', 'url' => ["/paciente/index", "status" => 'LE'], 
                                'visible' => Yii::$app->user->identity->tipo == '4'], 
                            ['label' => 'Devolvidos', 'url' => ["/paciente/index", "status" => 'DV'], 
                                'visible' => Yii::$app->user->identity->tipo == '4'], 
                            ['label' => 'Entrar em Contato', 'url' => [Yii::$app->user->identity->tipo == '4' ? "/paciente/index": "/paciente/meus-pacientes", 
                                "status" => 'EC']], 
                            ['label' => 'Em Atendimento', 'url' => [Yii::$app->user->identity->tipo == '4' ? "/paciente/index" : "/paciente/meus-pacientes",
                                "status" => 'EA']],
                            ['label' => 'Desistente', 'url' => [Yii::$app->user->identity->tipo == '4' ? "/paciente/index" : "/paciente/meus-pacientes",
                                "status" => 'DE']],
                            ['label' => 'Abandono', 'url' => [Yii::$app->user->identity->tipo == '4' ? "/paciente/index" : "/paciente/meus-pacientes",
                                "status" => 'AB']],                            
                            ['label' => 'Alta', 'url' => [Yii::$app->user->identity->tipo == '4' ? "/paciente/index" : "/paciente/meus-pacientes",
                                "status" => 'AL']], 
                            ['label' => 'Todos', 'url' => [Yii::$app->user->identity->tipo == '4' ? "/paciente/index" : "/paciente/meus-pacientes",
                                "status" => '']], 
                            ],
                        ]: "",
                    
                    !Yii::$app->user->isGuest ? [
                        'label' => 'Usuários',
                        'icon' => 'fa fa-users',
                        'items' => [
                            ['label' => 'Professores', 'url' => ["/user/index", "perfil" =>1]], 
                            ['label' => 'Psicólogos', 'url' => ["/user/index", "perfil" =>2]], 
                            ['label' => 'Terapeutas', 'url' => ["/user/index", "perfil" =>3]], 
                            ['label' => 'Administradores', 'url' => ["/user/index", "perfil" =>4]], 
                        ], 
                        'visible' => Yii::$app->user->identity->tipo == '4',
                        ] : "",
                    !Yii::$app->user->isGuest ? ['label' => 'Alocações de Pacientes', 'icon' => 'fa fa-street-view', 'url' => ['/usuario-paciente/index'], 'visible' => Yii::$app->user->identity->tipo == '4'] : "",
                    !Yii::$app->user->isGuest ? ['label' => 'Dados Estatísticos', 'icon' => 'fa fa-book', 'url' => ['/relatorio/index'], 'visible' => Yii::$app->user->identity->tipo != '0'] : "",
                ],
            ]
        ) ?>

    </section>

</aside>
