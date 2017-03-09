<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Agenda;
use app\models\Paciente;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SessaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Principal';
?>
<div class="sessao-index">

    <legend><h1>Sessões Agendadas</h1></legend>
    
    <?= GridView::widget([
        'dataProvider' => $dataSessoesEE,
        //'filterModel' => $searchMSessoesEE,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
            'attribute' => 'Paciente_id',
                'label' => "Paciente",
                'value' => function ($model){
                    $paciente = Paciente::find()->where(['id' => $model->Paciente_id])->one();
                    return $paciente->nome;
                }

            ],
            [
                'label' => 'Data ',
                'value' => function ($model){

                    $agenda = Agenda::find()->where(['id' => $model->Agenda_id])->one();

                   return $agenda->data_inicio;
                }
            ],
            [
                'label' => 'Hora Inicial',
                'value' => function ($model){

                    $agenda = Agenda::find()->where(['id' => $model->Agenda_id])->one();

                   return $agenda->horaInicio;
                }
            ],
            [
                'label' => 'Status',
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchMSessoesEE, 'status', ['EE' => 'Em Espera', 'NO' => 'Não Ocorrida', 
                    'OS' => 'Ocorrida', 'FE' => 'Fechada'],
                        ['class'=>'form-control','prompt' => 'Selecione um Status']),
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

    
    <legend><h1>Pacientes Pendendes de Contato</h1></legend>
    
    <?= GridView::widget([
        'dataProvider' => $dataPacienteContato,
        'filterModel' => $searchPacienteContato,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'nome',
            'telefone',
            
            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view} {update} {sessao} {encaminhar}',
                'buttons'=>[
                    'sessao' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-blackboard"></span>', ['sessao/all', 'id' => $model->id], [
                                'title' => Yii::t('yii', 'Sessões'),
                        ]);   
                    },
                    'encaminhar' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['usuario-paciente/encaminhar', 'id' => $model->id,
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
                ]
            ],
        ],
    ]); ?>
</div>
