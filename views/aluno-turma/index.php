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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Turma',
                'attribute' => 'Disciplina_id',
                'value' => function($model){
                    return $model->disciplina->nome." - Turma".$model->codigo;
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
