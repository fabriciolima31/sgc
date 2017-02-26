<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProfessorTurma */

$this->title = $model->Turma_id;
$this->params['breadcrumbs'][] = ['label' => 'Professor Turmas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="professor-turma-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'Turma_id' => $model->Turma_id, 'Usuarios_id' => $model->Usuarios_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'Turma_id' => $model->Turma_id, 'Usuarios_id' => $model->Usuarios_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Turma_id',
            'Usuarios_id',
        ],
    ]) ?>

</div>
