<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Agenda;
use app\models\Paciente;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SessaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sessões Realizadas';
$this->params['breadcrumbs'][] = ['label' => 'Sessões Realizadas - Pacientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sessao-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Nova Sessão', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
            'attribute' => 'Paciente_id',
                'label' => "Paciente",
                'value' => function ($model){
                    $paciente = Paciente::find()->where(['id' => $model->Paciente_id])->one();
                    return $paciente->nome;
                }

            ],
            [
                'label' => 'Data ',
                'value' => function ($model){

                    $agenda = Agenda::find()->where(['id' => $model->Agenda_id])->one();

                   return $agenda->data_inicio;
                }
            ],
            [
                'label' => 'Hora Inicial',
                'value' => function ($model){

                    $agenda = Agenda::find()->where(['id' => $model->Agenda_id])->one();

                   return $agenda->horaInicio;
                }
            ],
            //'horario',
            'status',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
