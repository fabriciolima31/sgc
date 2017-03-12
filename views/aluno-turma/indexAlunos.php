<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlunoTurmaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alocações de Alunos em Turmas - Alunos';
$this->params['breadcrumbs'][] = ['label' => 'Alocações de Alunos em Turmas  - Turmas', 'url' => ['index']];
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

            'usuario.nome',

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view}',
            ],
        ],
    ]); ?>
</div>
