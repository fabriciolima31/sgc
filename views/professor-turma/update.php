<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioTurma */

$this->title = 'Update Usuario Turma: ' . $model->Turma_id;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Turmas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Turma_id, 'url' => ['view', 'Turma_id' => $model->Turma_id, 'Usuarios_id' => $model->Usuarios_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuario-turma-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
