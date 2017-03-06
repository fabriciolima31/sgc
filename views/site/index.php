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
        //'filterModel' => $searchModel,
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
            //'horario',
            'status',
            
            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['paciente/view', 'id' => $model->id], [
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
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'nome',
            'telefone',
            'statusDesc',
            
            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['paciente/view', 'id' => $model->id], [
                            'title' => Yii::t('yii', 'Detalhes'),
                    ]);   
                  }
                ]
            ],
        ],
    ]); ?>
</div>
