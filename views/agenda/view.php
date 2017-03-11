<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use app\models\Disciplina;

/* @var $this yii\web\View */
/* @var $model app\models\Agenda */

$this->title = $model->consultorio->nome;
$this->params['breadcrumbs'][] = ['label' => 'Agendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agenda-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Remover este Agendamento', ['altera-status', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você tem certeza que deseja apagar este agendamento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
            'attribute' => 'consultorio.nome',
            'label' => 'Local'
            ],
            [
                'attribute'=>'data_inicio',
                'label' => 'Data',
            ],
            //'data_fim',
            [
            'attribute' => 'diaSemana',
            'label' => 'Dia da Semana',
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
            ['attribute' => 'Turma_id',
            'label' => 'Disciplina',
            'value' => function ($model){
                    $disciplina = Disciplina::find()
                    ->select("Disciplina.nome")
                    ->innerJoin("Turma as T","T.Disciplina_id = Disciplina.id" )
                    ->where(["T.id"=>$model->Turma_id])->one();
                    return $disciplina->nome;

            }
            ],

        ],
    ]) ?>

</div>
