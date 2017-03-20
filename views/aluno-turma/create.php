<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AlunoTurma */

$this->title = 'Alocar Aluno à Turma: '. $model->turma->disciplina->nome.' - '.$model->turma->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Turmas - Alunos Alocados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Alunos - Alunos Alocados', 'url' => ['index-alunos', 'id' => $model->Turma_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-turma-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
