<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Pacientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paciente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Alocar', ['usuario-paciente/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Remover', ['delete', 'id' => $model->id], [
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
