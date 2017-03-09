<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UsuarioPaciente */

$this->title = 'Alocar Terapeuta';
$this->params['breadcrumbs'][] = ['label' => 'Pacientes Alocados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-paciente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'existe_usuario_paciente' => $existe_usuario_paciente,
    ]) ?>

</div>
