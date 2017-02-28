<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PacienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pacientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paciente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Paciente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nome',
            'status',
            // 'sexo',
            // 'data_nascimento',
            // 'telefone',
            // 'endereco',
            // 'moradia:ntext',
            // 'turno_atendimento',
            // 'local_encaminhamento:ntext',
            // 'local_terapia:ntext',
            // 'motivo_psicoterapia',
            // 'servico:ntext',
            // 'observacao:ntext',
             'statusDesc',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
