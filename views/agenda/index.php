<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Agenda;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AgendaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$agenda = new Agenda();
$agendaDependencias = $agenda->dependenciasAgendamento();

    if ($agendaDependencias != []){ ?>
        <div class="alert alert-danger" style="text-align: center">
            Atenção: <strong> Requisitos insuficientes para criar agendamento. Cadastre ou ative os seguintes itens: <?= implode(', ', $agendaDependencias) ?>. </strong>
        </div>
    <?php }



$this->title = 'Reserva de Consultório';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agenda-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::$app->user->identity->tipo == '4' ? Html::a('Adicionar Reserva', ['create'], ['class' => 'btn btn-success']) : "" ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
            'attribute'=>'nome_do_consultorio',
            'label' => 'Local',
            ],
            'data_inicio',
            //'data_fim',
            [
                'attribute'=>'diaSemana',
                'filter'=> array
                    (1 => 'Segunda-Feira', 2 => 'Terça-Feira', 3 => 'Quarta-Feira', 
                        4 => 'Quinta-Feira',  5 => 'Sexta-Feira', 6 => 'Sábado', 0 => 'Domingo', 
                    ),

                'value' => function ($model){
                        $arraySemana = array([
                            1 => 'Segunda-Feira',
                            2 => 'Terça-Feira',
                            3 => 'Quarta-Feira',
                            4 => 'Quinta-Feira',
                            5 => 'Sexta-Feira',
                            6 => 'Sábado',
                            0 => 'Domingo',
                            ]);
                        return $arraySemana[0][$model->diaSemana];
                }
            ],
            'horaInicio',
            ['attribute' => 'nome_de_quem_agenda',
            'label' => 'Aluno Terapeuta',
            ],

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view}',
                'buttons'=>[
                  'view' => function ($url, $model) {  
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['agenda/view', 'id' => $model->id], [
                            'title' => Yii::t('yii', 'Visualizar Detalhes'),
                    ]);                                
                  },
              ]                            
            ],
        ],
    ]); ?>
</div>
