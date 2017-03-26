<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Dados Estatíticos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 

        echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Disciplina',
                'attribute' => 'nome',
            ],
            [
                'attribute'=>'data_inicio',
                'format' => ['date', 'php:d-m-Y'],
            ],
            [
                'attribute'=>'data_fim',
                'format' => ['date', 'php:d-m-Y'],
            ],
            'quantidade_atendimentos',
        ],
    ]); 


    ?>
</div>
