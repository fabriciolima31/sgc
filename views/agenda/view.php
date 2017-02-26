<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Agenda */

$this->title = $model->Consultorio_id;
$this->params['breadcrumbs'][] = ['label' => 'Agendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agenda-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'Consultorio_id' => $model->Consultorio_id, 'Usuarios_id' => $model->Usuarios_id, 'diaSemana' => $model->diaSemana, 'horaInicio' => $model->horaInicio, 'status' => $model->status], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'Consultorio_id' => $model->Consultorio_id, 'Usuarios_id' => $model->Usuarios_id, 'diaSemana' => $model->diaSemana, 'horaInicio' => $model->horaInicio, 'status' => $model->status], [
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
            'Consultorio_id',
            'Usuarios_id',
            'diaSemana',
            'horaInicio',
            'horaFim',
            'status',
        ],
    ]) ?>

</div>
