<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'Paciente_id',
            'data',
            'horario',
            'status',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
