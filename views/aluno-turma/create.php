<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AlunoTurma */

$this->title = 'Alocar Aluno à Turma';
$this->params['breadcrumbs'][] = ['label' => 'Alocações de Alunos em Turmas - Alunos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-turma-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
