<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Agenda */

$this->title = 'Update Agenda: ' . $model->Consultorio_id;
$this->params['breadcrumbs'][] = ['label' => 'Agendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Consultorio_id, 'url' => ['view', 'Consultorio_id' => $model->Consultorio_id, 'Usuarios_id' => $model->Usuarios_id, 'diaSemana' => $model->diaSemana, 'horaInicio' => $model->horaInicio, 'status' => $model->status]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="agenda-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
