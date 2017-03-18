<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AgendaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agendamento';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agenda-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Yii::$app->user->identity->tipo == '4' ? Html::a('Criar Agendamento', ['create'], ['class' => 'btn btn-success']) : "" ?>
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
