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

            ['label' => 'Disciplinas', 'url' => ['/disciplina/index']],
            ['label' => 'Turmas', 'url' => ['/turma/index']],
            ['label' => 'Paciente', 'url' => ['/paciente/index']],
            [
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
            ],
            ['label' => 'Sessão', 'url' => ['/sessao/index']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
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
