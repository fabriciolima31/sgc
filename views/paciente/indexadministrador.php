<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PacienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pacientes - '.$statusDescricao;
$this->params['breadcrumbs'][] = $this->title;

//var_dump($dataProvider->getModels());die;


?>
<div class="paciente-index">

    <h1><?= Html::encode($this->title) ?></h1>
   
    <p>
        <?= Html::a('Adicionar Paciente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            /*'rowOptions'=>function($model){
                if($model->nome_do_terapeuta == null){
                    return ['class' => 'warning'];
                }
            },
            */
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
    
                'nome',
                [
                'attribute'=>'nome_do_terapeuta',
                'format' => 'raw',
                'value' => function ($model){
                    if($model->nome_do_terapeuta == null){
                        return "<div style='color:red'> <b>Não foi alocado</b> </div>";
                    }
                    return $model->nome_do_terapeuta;
    
                },
                ],
                [
                    'label' => 'Situação',
                    'visible' => $statusDescricao != 'Todos' ? false : true,
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
                        return $model->complexidadeDesc;
                    }
                ],
                [
                    'label' => 'Turno',
                    'attribute' => 'turno_atendimento',
                    'filter' => Html::activeDropDownList($searchModel, 'turno_atendimento', ['M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite', 'Q' => 'Qualquer'],
                            ['class'=>'form-control','prompt' => '']),
                    'value' => function ($model) {
                        return $model->turnoAtendimentoDesc;
                    }
                ],
    
                ['attribute' => 'data_inscricao',
                'label' => 'Data Inscrição',
                'value' => function ($model){
    
                    return date("d-m-Y",strtotime($model->data_inscricao));
    
                }
                ],
    
                ['class' => 'yii\grid\ActionColumn',
                  'template'=>'{view} {update}',
                ]
            ],
        ]); ?>
    </div>
</div>
