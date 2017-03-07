<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PacienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pacientes - '.$statusDescricao;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paciente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nome',
            'statusDesc',

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{view} {update} {sessao}',
                'buttons'=>[
                    'sessao' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-blackboard"></span>', ['sessao/all', 'id' => $model->id], [
                            'title' => Yii::t('yii', 'Sessões'),
                    ]);   
                  }
                ]
            ],
        ],
    ]); ?>
</div>
