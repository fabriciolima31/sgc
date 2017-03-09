<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Sistema de Gerenciamento de Consultas',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [

            !Yii::$app->user->isGuest ? ['label' => 'Disciplinas', 'url' => ['/disciplina/index'], 'visible' => Yii::$app->user->identity->tipo == '4']: "",
            !Yii::$app->user->isGuest ? ['label' => 'Consultórios', 'url' => ['/consultorio/index'], 'visible' => Yii::$app->user->identity->tipo == '4']: "",
            !Yii::$app->user->isGuest ? ['label' => 'Agendamento', 'url' => ['/agenda/index'], 'visible' => Yii::$app->user->identity->tipo != '4']: "",
            !Yii::$app->user->isGuest ? ['label' => 'Turmas', 'url' => ['/turma/index'], 'visible' => Yii::$app->user->identity->tipo == '4'] : "",
            !Yii::$app->user->isGuest ? [
            'label' => 'Paciente',
            'items' => [
                ['label' => 'Lista de Espera', 'url' => ["/paciente/index", "status" => 'LE'], 
                    'visible' => Yii::$app->user->identity->tipo == '4'], 
                '<li class="divider"></li>', 
                ['label' => 'Entrar em Contato', 'url' => [Yii::$app->user->identity->tipo == '4' ? "/paciente/index": "/paciente/meus-pacientes", 
                    "status" => 'EC']], 
                '<li class="divider"></li>',
                ['label' => 'Em Atendimento', 'url' => [Yii::$app->user->identity->tipo == '4' ? "/paciente/index" : "/paciente/meus-pacientes",
                    "status" => 'EA']],
                '<li class="divider"></li>',
                ['label' => 'Desistente', 'url' => [Yii::$app->user->identity->tipo == '4' ? "/paciente/index" : "/paciente/meus-pacientes",
                    "status" => 'DE']], 
                '<li class="divider"></li>',
                ['label' => 'Abandono', 'url' => [Yii::$app->user->identity->tipo == '4' ? "/paciente/index" : "/paciente/meus-pacientes",
                    "status" => 'AB']], 
                '<li class="divider"></li>',
                ['label' => 'Alta', 'url' => [Yii::$app->user->identity->tipo == '4' ? "/paciente/index" : "/paciente/meus-pacientes",
                    "status" => 'AL']], 
                ],
            ]: "",
            !Yii::$app->user->isGuest ? [
            'label' => 'Usuários',
            'items' => [
                ['label' => 'Professores', 'url' => ["/user/index", "perfil" =>1]], 
                '<li class="divider"></li>', 
                ['label' => 'Psicólogos', 'url' => ["/user/index", "perfil" =>2]], 
                '<li class="divider"></li>',
                ['label' => 'Terapeutas', 'url' => ["/user/index", "perfil" =>3]], 
                '<li class="divider"></li>',
                ['label' => 'Administradores', 'url' => ["/user/index", "perfil" =>4]], 
                ],
                'visible' => Yii::$app->user->identity->tipo == '4',
            ] : "",
            !Yii::$app->user->isGuest ? ['label' => 'Alocações', 'url' => ['/usuario-paciente/index'], 'visible' => Yii::$app->user->identity->tipo == '4'] : "",
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->cpf . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Sistema de Gerenciamento de Consultas <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
