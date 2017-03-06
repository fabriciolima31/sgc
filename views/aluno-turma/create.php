<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AlunoTurma */

$this->title = 'Create Aluno Turma';
$this->params['breadcrumbs'][] = ['label' => 'Aluno Turmas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-turma-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
