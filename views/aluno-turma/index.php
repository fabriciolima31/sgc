<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlunoTurmaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alocações de Alunos em Turmas - Turmas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-turma-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Alocar Aluno à Turma', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Turma',
                'attribute' => 'Turma_id',
                'value' => function($model){
                    return $model->turma->disciplina->nome." - Turma".$model->turma->codigo;
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view}',
                 'buttons'=>[
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['aluno-turma/index-alunos','id' => $model->Turma_id,], [
                            'title' => Yii::t('yii', 'Regitrar Consulta Ocorrida'),
                    ]);
                  },
                ]
            ],
        ],
    ]); ?>
</div>
