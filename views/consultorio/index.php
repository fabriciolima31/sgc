<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsultorioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consultorios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultorio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Novo Consultório', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nome',

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{update} {habilitar} {desabilitars}',
                'buttons'=>[
                    'habilitar' => function ($url, $model) {
                        return $model->status == 'EE' ? Html::a('<span class="glyphicon glyphicon-ok-sign"></span>', ['sessao/altera-status','status' => 'OS',
                        'idPaciente' => $model->Paciente_id, 'idSessao' => $model->id], [
                            'title' => Yii::t('yii', 'Regitrar Consulta Ocorrida'),
                    ]) : "" ;
                  },
                ]
            ],
        ],
    ]); ?>
</div>