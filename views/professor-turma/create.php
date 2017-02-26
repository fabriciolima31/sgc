<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProfessorTurma */

$this->title = 'Create Professor Turma';
$this->params['breadcrumbs'][] = ['label' => 'Professor Turmas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="professor-turma-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
