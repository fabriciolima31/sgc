<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Agenda;
use app\models\Paciente;
use app\models\Relatorio;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SessaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Principal';
?>
<div class="sessao-index">

    <legend><h2>Sessões Agendadas</h2></legend>
    
    <?= GridView::widget([
        'dataProvider' => $dataSessoesEE,
        'filterModel' => $searchMSessoesEE,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
            'attribute' => 'nome_do_paciente',
                'label' => "Paciente",

            ],
            [
                'label' => 'Data ',
                'attribute'=> 'data_inicio_consulta',
                'format' => ['date', 'php:d-m-Y'],

            ],
            [
                'label' => 'Hora Inicial',
                'attribute' => 'hora_inicio_consulta',
            ],
            [
                'label' => 'Status',
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchMSessoesEE, 'status', ['EE' => 'Em Espera', 'NO' => 'Não Ocorrida', 'OS' => 'Ocorrida', 'FE' => 'Fechada'], ['class'=>'form-control','prompt' => 'Selecione um Status']),
                //'filter' => '',
                'value' => function ($model) {
                    return $model->statusDesc;
                }
            ],
            
            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['paciente/view', 'id' => $model->Paciente_id], [
                            'title' => Yii::t('yii', 'Detalhes'),
                    ]);   
                  }
                ]
            ],
        ],
    ]); ?>

    
    <legend><h2>Pacientes Pendentes de Contato</h2></legend>
    
    <?= GridView::widget([
        'dataProvider' => $dataPacienteContato,
        'filterModel' => $searchPacienteContato,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'nome',
            'telefone',
            [
                'label' => 'Prioridade',
                'attribute' => 'prioridade',
                'filter' => Html::activeDropDownList($searchPacienteContato, 'prioridade', ['A' => 'Alta', 'M' => 'Média', 'N' => 'Normal', 'B' => 'Baixa'],
                        ['class'=>'form-control','prompt' => '']),
                'value' => function ($model) {
                    return $model->prioridadeDesc;
                }
            ],
            [
                'label' => 'Complexidade',
                'attribute' => 'complexidade',
                'filter' => Html::activeDropDownList($searchPacienteContato, 'complexidade', ['A' => 'Alta', 'M' => 'Média', 'N' => 'Normal', 'B' => 'Baixa'],
                        ['class'=>'form-control','prompt' => '']),
                'value' => function ($model) {
                    return $model->complexidadeDesc;
                }
            ],
            [
                'label' => 'Turno',
                'attribute' => 'turno_atendimento',
                'filter' => Html::activeDropDownList($searchPacienteContato, 'turno_atendimento', ['M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite'],
                        ['class'=>'form-control','prompt' => '']),
                'value' => function ($model) {
                    return $model->turnoAtendimentoDesc;
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
                    return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['usuario-paciente/encaminhar', 'id' => $model->id,
                        ], [
                                'title' => Yii::t('yii', 'Encaminhar Para Lista de Espera'),            
                        'data' => [
                        'confirm' => 'Você tem certeza que deseja encaminhar este paciente de volta para a LISTA DE ESPERA?',
                        'method' => 'post',

                        ],
                        ]);   
                    },
                   'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['paciente/update', 'id' => $model->id], [
                                'title' => Yii::t('yii', 'Atualizar'),
                        ]);   
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['paciente/view', 'id' => $model->id], [
                                'title' => Yii::t('yii', 'Visualizar'),
                        ]);   
                    },
                ]
            ],
        ],
    ]); ?>


    <?php
    
        if(Yii::$app->user->identity->tipo == '3' || Yii::$app->user->identity->tipo == '2'){
            
            $request = Yii::$app->request;
            $id = Yii::$app->user->identity->id;

            $model = new Relatorio();
            $html = $model->getDadosParaRelatorio($id);
            echo $html;
        }


    ?>


</div>
