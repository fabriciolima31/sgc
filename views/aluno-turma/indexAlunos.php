<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlunoTurmaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Turmas - Alunos Alocados em '.$turma->disciplina->nome." - ".$turma->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Turmas - Alunos Alocados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aluno-turma-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Alocar Aluno à Turma', ['create', 'id' => $id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nome_do_aluno',

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{desalocar}',
                'buttons'=>[
                    'desalocar' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', ['aluno-turma/delete','Turma_id' => $model->Turma_id,
                            'Usuarios_id' => $model->Usuarios_id], [
                            'data' => [
                                'confirm' => 'Você tem certeza desalocar o aluno \''.$model->usuario->nome.'\'?',
                                'method' => 'post',],
                            'title' => Yii::t('yii', 'Desalocar'),
                    ]);
                  },
                ]
            ],
        ],
    ]); ?>
</div>
