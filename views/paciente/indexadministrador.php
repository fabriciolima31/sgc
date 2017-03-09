<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Paciente;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PacienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pacientes - '.$statusDescricao;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paciente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Paciente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nome',            
            [
                'label' => 'Status',
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', ["EN"=> "Encaminhado", "LE" => "Lista de Espera", 'EC' => "Entrar em Contato", 
        "EA" => "Em Atendimento", "DE" => "Desistente", "AB" => "Abandono", "AL" => "Alta"],
                        ['class'=>'form-control','prompt' => '']),
                'value' => function ($model) {
                    return $model->statusDesc;
                }
            ],
            [
                'label' => 'Prioridade',
                'attribute' => 'prioridade',
                'filter' => Html::activeDropDownList($searchModel, 'prioridade', ['A' => 'Alta', 'M' => 'Média', 'N' => 'Normal', 'B' => 'Baixa'],
                        ['class'=>'form-control','prompt' => '']),
                'value' => function ($model) {
                    return $model->prioridadeDesc;
                }
            ],
            [
                'label' => 'Complexidade',
                'attribute' => 'complexidade',
                'filter' => Html::activeDropDownList($searchModel, 'complexidade', ['A' => 'Alta', 'M' => 'Média', 'N' => 'Normal', 'B' => 'Baixa'],
                        ['class'=>'form-control','prompt' => '']),
                'value' => function ($model) {
                    return $model->prioridadeDesc;
                }
            ],
            [
                'label' => 'Turno',
                'attribute' => 'turno_atendimento',
                'filter' => Html::activeDropDownList($searchModel, 'turno_atendimento', ['M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite'],
                        ['class'=>'form-control','prompt' => '']),
                'value' => function ($model) {
                    return $model->turnoAtendimentoDesc;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
