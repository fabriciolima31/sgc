<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Turmas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>

    <h4 style="text-align: center; font-weight: bold; color: blue"> Escolha uma Turma para Visualizar a Quantidade de Atendimentos de cada Aluno </h4>
    <br>
    <?php 

        echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Disciplina',
                'attribute' => 'nome',
            ],
            [
                'label' => 'Código da Turma',
                'attribute' => 'codigo_turma',
            ],
            [
                'attribute'=>'data_inicio',
                'format' => ['date', 'php:d-m-Y'],
            ],
            [
                'attribute'=>'data_fim',
                'format' => ['date', 'php:d-m-Y'],
            ],

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view}',
            ]
        ],
    ]); 


    ?>
</div>
