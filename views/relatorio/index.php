<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Disciplinas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php //echo $relatorio ?>


    <?php 

        echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'nome',
            'codigo_turma',
            'data_inicio',
            'data_fim',

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view}',
            ]
        ],
    ]); 


    ?>
</div>
