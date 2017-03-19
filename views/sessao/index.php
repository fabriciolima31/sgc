<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Agenda;

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
        <?= $paciente->statusFinal() ? Html::a('Adicionar Sessão', ['create', 'id'=> Yii::$app->request->get('id') ], ['class' => 'btn btn-success']) : "" ?>
        <?php //echo $paciente->statusFinal() ? Html::a('Ir para Agendamento', ['agenda/create'], ['class' => 'btn btn-primary']) : "" ?>
        <?= $paciente->statusFinal() && Yii::$app->user->identity->tipo == '3' ?  Html::a('Dar Alta ao Paciente', ['paciente/alterar-status', 'id' => $paciente->id, 'status' => 'AL'], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Atribuir Alta para o paciente?',
                'method' => 'post',
            ],
        ]) : "" ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'label' => 'Data ',
                'attribute' => 'data_inicio_consulta',
                'format' => ['date', 'php:d-m-Y'],
            ],
            [
                'label' => 'Hora Inicial',
                'attribute'=> 'hora_inicio_consulta',

            ],
            [
                'label' => 'Status',
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', ['EE' => 'Em Espera', 'NO' => 'Não Ocorrida', 'OS' => 'Ocorrida', 'FE' => 'Fechada'],
                        ['class'=>'form-control','prompt' => '']),
                'value' => function ($model) { 
                   return $model->statusDesc;
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{ocorreu} {naoocorreu}  {deletar}',
                'buttons'=>[
                    'ocorreu' => function ($url, $model) {
                        return $model->status == 'EE' ? Html::a('<span class="glyphicon glyphicon-ok-sign"></span>', ['sessao/altera-status','status' => 'OS',
                        'idPaciente' => $model->Paciente_id, 'idSessao' => $model->id , 'idAgenda' => $model->Agenda_id], [
                            'title' => Yii::t('yii', 'Regitrar Consulta Ocorrida'),
                    ]) : "" ;
                  },
                    'naoocorreu' => function ($url, $model) {
                        return $model->status == 'EE' ? Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', ['sessao/altera-status', 'status' => 'NO', 
                            'idPaciente' => $model->Paciente_id, 'idSessao' => $model->id , 'idAgenda' => $model->Agenda_id], [
                            'title' => Yii::t('yii', 'Registrar consulta não ocorrida'),
                    ]) : "";   
                  },
                'deletar' => function ($url, $model) {
                        return $model->status == 'EE' ? Html::a('<span class="glyphicon glyphicon-remove"></span>', ['sessao/altera-status', 'status' => 'DL', 
                            'idPaciente' => $model->Paciente_id, 'idSessao' => $model->id , 'idAgenda' => $model->Agenda_id], [
                            'title' => Yii::t('yii', 'Remover esta Sessão'),
                    ]) : "";   
                  },
                ]
            ],
        ],
    ]); ?>
</div>
