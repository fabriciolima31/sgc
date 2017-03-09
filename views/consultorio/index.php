<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsultorioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consultórios';
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
            [
                'label' => 'Status',
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', ['1' => 'Habilitado', '0' => 'Desabilitado'],
                        ['class'=>'form-control','prompt' => 'Selecione um Status']),
                'value' => function ($model) {
                    return $model->status == '1' ? 'Hablitado' : 'Desabilitado';
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{update} {status}',
                'buttons'=>[
                    'status' => function ($url, $model) {
                        return $model->status == '1' ? Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', ['altera-status', 'id' => $model->id , 'status' => '0'], [
                            'title' => Yii::t('yii', 'Desabilitar Consultório'),
                    ]) : Html::a('<span class="glyphicon glyphicon-ok-sign"></span>', ['altera-status', 'id' => $model->id, 'status' => '1'], [
                            'title' => Yii::t('yii', 'Habilitar Consultório'),
                    ]) ;
                  },
                ]
            ],
        ],
    ]); ?>
</div>