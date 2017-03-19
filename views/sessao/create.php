<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sessao */


$this->title = 'Adicionar Sessão';
$this->params['breadcrumbs'][] = ['label' => 'Pacientes', 'url' => ['/paciente/meus-pacientes', 'status' => 'EC']];
$this->params['breadcrumbs'][] = ['label' => 'Sessões', 'url' => ['/sessao/all', 'id' => $model->Paciente_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sessao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'quantidadeAgendamentosVagos' => $quantidadeAgendamentosVagos,
    ]) ?>

</div>
