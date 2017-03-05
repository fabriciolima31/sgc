<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Agenda */

$this->title = $model->consultorio->nome;
$this->params['breadcrumbs'][] = ['label' => 'Agendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agenda-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php 
        //echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Remover este Agendamento', ['delete', 'id' => $model->id], [
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
            'horaFim',

        ],
    ]) ?>

</div>
