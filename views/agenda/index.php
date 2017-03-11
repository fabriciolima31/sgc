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
        <?= Html::a('Criar Agendamento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
            'attribute'=>'consultorio.nome',
            'label' => 'Local',
            ],
            'data_inicio',
            //'data_fim',
            [
                'attribute'=>'diaSemana',
                'value' => function ($model){
                        $arraySemana = array([
                            0 => 'Domingo',
                            1 => 'Segunda-Feira',
                            2 => 'Terça-Feira',
                            3 => 'Quarta-Feira',
                            4 => 'Quinta-Feira',
                            5 => 'Sexta-Feira',
                            6 => 'Sábado',
                            ]);
                        return $arraySemana[0][$model->diaSemana];
                }
            ],
            'horaInicio',
            ['attribute' => 'Usuarios_id',
            'label' => 'Aluno Terapeuta',
            'value' => function ($model){
                    $usuario = User::find()->select("Usuarios.nome")->where(["id"=>$model->Usuarios_id])->one();
                    return $usuario->nome;

            }
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
