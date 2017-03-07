<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Agenda;
use app\models\Paciente;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SessaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sessões de '.$paciente->nome;
$this->params['breadcrumbs'][] = ['label' => 'Pacientes', 'url' => ['paciente/meus-pacientes', 'status' => $paciente->status]];
$this->params['breadcrumbs'][] = ['label' => $paciente->nome, 'url' => ['paciente/view', 'id' => $paciente->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sessao-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Adicionar Sessão', ['create', 'id'=> Yii::$app->request->get('id') ], ['class' => 'btn btn-success']) ?>
        <?= Yii::$app->user->identity->tipo == '3' ?  Html::a('Dar Alta', ['alterar-status', 'id' => $paciente->id, 'status' => 'AL'], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Atribuir Alta para o paciente?',
                'method' => 'post',
            ],
        ]) : "" ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
//            [
//            'attribute' => 'Paciente_id',
//                'label' => "Paciente",
//                'value' => function ($model){
//                    $paciente = Paciente::find()->where(['id' => $model->Paciente_id])->one();
//                    return $paciente->nome;
//                }
//
//            ],
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
            
            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view} {ocorreu} {naoocorreu}',
                'buttons'=>[
                    'ocorreu' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-ok-sign"></span>', ['sessao/altera-status','status' => 'OS',
                        'id' => $model->Paciente_id], [
                            'title' => Yii::t('yii', 'Regitrar Consulta Ocorrida'),
                    ]) ;   
                  },
                    'naoocorreu' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', ['sessao/altera-status', 'status' => 'OS', 'id' => $model->Paciente_id], [
                            'title' => Yii::t('yii', 'Registrar consulta não ocorrida'),
                    ]);   
                  }
                ]
            ],
        ],
    ]); ?>
</div>
