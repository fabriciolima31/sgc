<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioPacienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Paciente Alocados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-paciente-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Paciente',
                'value' => 'paciente.nome',
            ],
            [
                'label' => 'Terapeura',
                'value' => 'usuario.nome',
            ],
            [
                'label' => 'Paciente Status',
                'value' => 'paciente.status',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
