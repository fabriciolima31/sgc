<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
$url = Yii::$app->user->identity->tipo == '3' ? 'meus-pacientes' : 'index';
        
$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Pacientes', 'url' => [$url, 'status' => $model->status]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paciente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= (Yii::$app->user->identity->tipo == '4' && $pacienteJaAlocado != 1) ? Html::a('Alocar', ['usuario-paciente/create', 'id' => $model->id], ['class' => 'btn btn-primary']) : "" ?>
        <?= Yii::$app->user->identity->tipo == '3' ? Html::a('Sessões', ['sessao/all', 'id' => $model->id], ['class' => 'btn btn-success']) : "" ?>
        
        <?= $model->statusFinal() ? Html::a('Desistiu', ['alterar-status', 'id' => $model->id, 'status' => 'DE'], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Alterar Status para Desistente?',
                'method' => 'post',
            ],
        ]) : "" ?>
        
        <?= $model->statusFinal() ? Html::a('Abandonou', ['alterar-status', 'id' => $model->id, 'status' => 'AB'], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Alterar Status para Abandono?',
                'method' => 'post',
            ],
        ]) : "" ?>
        <?= Html::a('Editar Dados', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nome',
            'statusDesc',
            ['label' =>'Sexo',
            'attribute' => 'sexo',
                'value' => function ($model){
                    return $model->sexo ? "Masculino" : "Feminino";
                }
            ],
            'data_nascimento',
            'telefone',
            'endereco',
            'moradia:ntext',
            ['label' =>'Turno de Atendimento',
            'attribute' => 'turno_atendimento',
                'value' => function ($model){
                    $array = ['M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite'];
                    return $array[$model->turno_atendimento];
                }
            ],
            'local_encaminhamento:ntext',
            'local_terapia:ntext',
            'motivo_psicoterapia',
            'servico:ntext',
            'observacao:ntext',
        ],
    ]) ?>

</div>
