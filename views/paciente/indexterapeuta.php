<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PacienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pacientes - '.$statusDescricao;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paciente-index">

    <h1><?= Html::encode($this->title) ?></h1>

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
                'attribute' => 'telefone',
            ]
            ,

            [
                'attribute'=>'data_inscricao',
                'label' => 'Data do Cadastro',
                'value' => function ($model){
                    
                    return date("d-m-Y - H:i ", strtotime($model->data_inscricao));
                    //return $model->data_inscricao;
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view} {update} {sessao} {encaminhar}',
                'buttons'=>[
                    'sessao' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-blackboard"></span>', ['sessao/all', 'id' => $model->id], [
                            'title' => Yii::t('yii', 'Sessões'),
                    ]);   
                  },
                    'encaminhar' => function ($url, $model) {  

                    return $model->status == 'EC' || $model->status == 'EA' ? Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['usuario-paciente/encaminhar', 'id' => $model->id,
                        ], [
                                'title' => Yii::t('yii', 'Encaminhar Para Lista de Espera'),
                                
                    'data' => [
                        'confirm' => 'Você tem certeza que deseja encaminhar este paciente de volta para a LISTA DE ESPERA?',
                        'method' => 'post',

                    ],
                    ]) : ""; 
                  },
                   'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['paciente/update', 'id' => $model->id], [
                            'title' => Yii::t('yii', 'Atualizar'),
                    ]);   
                  },
                ]
            ],
        ],
    ]); ?>
</div>

