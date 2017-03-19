<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlunoTurmaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Turmas - Alunos Alocados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-turma-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Selecione um turma para vizualizar os alunos alocados</p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Turma',
                'attribute' => 'codigo',
                'value' => function($model){
                    return $model->codigo;
                }
            ],

            [
                'label' => 'Disciplina',
                'attribute' => 'nome_da_disciplina',
                'value' => function($model){



                    return $model->nome_da_disciplina;
                }
            ],
            [
                'label' => 'Data Início',
                'attribute' => 'data_inicio',
                'value' => function($model){
                    return $model->data_inicio;
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view}',
                 'buttons'=>[
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['aluno-turma/index-alunos','id' => $model->id,], [
                            'title' => Yii::t('yii', 'Regitrar Consulta Ocorrida'),
                    ]);
                  },
                ]
            ],
        ],
    ]); ?>
</div>
