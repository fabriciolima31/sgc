<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\Disciplina;
use app\models\Turma;
use app\models\User;


/* @var $this yii\web\View */
/* @var $model app\models\Turma */

$this->title = $model->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Turmas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turma-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Remover', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você tem certeza que deseja REMOVER este item ?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Alunos Alocados', ['aluno-turma/index-alunos', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'codigo',
            [
                'label'=>'Professor',
                'value' => function ($model){

                        $user = Turma::find()->select("Usuarios.nome as nome_do_usuario")
                                             ->innerJoin('Professor_Turma','Turma.id = Professor_Turma.Turma_id')
                                             ->innerJoin('Usuarios','Usuarios.id = Professor_Turma.Usuarios_id')
                                             ->where(["Turma.id" => $model->id])->one();

                        return $user->nome_do_usuario;
                }
            ],
            ['label'=>'Disciplina',
                'attribute' => 'Disciplina_id',
                'value' => function ($model){

                $disciplina = ArrayHelper::map(Disciplina::find()->all(), 'id', 'nome');
                return $disciplina[$model->Disciplina_id];
                },
            ],
            'semestre',
            'ano',
            'data_inicio',
            'data_fim',
           
        ],
    ]) ?>

</div>
