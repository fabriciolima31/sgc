<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioPaciente */

$this->title = 'Update Usuario Paciente: ' . $model->Paciente_id;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Pacientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Paciente_id, 'url' => ['view', 'Paciente_id' => $model->Paciente_id, 'Usuarios_id' => $model->Usuarios_id, 'status' => $model->status]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuario-paciente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
