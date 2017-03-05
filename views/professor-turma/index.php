<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use app\models\Turma;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioTurmaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Turmas do Professor';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-turma-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Create Usuario Turma', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Professor',
                'value' => function ($model){
                    $user = User::find()->where(["id" => $model->Usuarios_id])->one();
                    return $user->nome;

                }
            ],
            [
                'label'=>'Código da Turma',
                'value' => function ($model){
                    $turma = Turma::find()->where(["id" => $model->Turma_id])->one();
                    return $turma->codigo;

                }
            ],
            [
                'label'=>'Disciplina',
                'value' => function ($model){
                    $disciplina = Turma::find()->select("Disciplina.nome as nome_da_disciplina")->innerJoin('Disciplina','Disciplina.id = Turma.Disciplina_id')->where(["Turma.id" => $model->Turma_id])->one();

                    return $disciplina->nome_da_disciplina;

                }
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
