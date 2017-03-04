<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioPaciente */

$this->title = $model->Paciente_id;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Pacientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-paciente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'Paciente_id' => $model->Paciente_id, 'Usuario_id' => $model->Usuario_id, 'status' => $model->status], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'Paciente_id' => $model->Paciente_id, 'Usuario_id' => $model->Usuario_id, 'status' => $model->status], [
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
            'Paciente_id',
            'Usuario_id',
            'status',
        ],
    ]) ?>

</div>
