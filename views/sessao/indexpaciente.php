<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SessaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sessões - Pacientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sessao-index">

    <h1><?= Html::encode($this->title) ?></h1>

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
                'label' => 'Paciente Status',
                'value' => 'paciente.statusDesc',
            ],

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{add} {view}',
                'buttons'=>[
                   'add' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-plus-sign"></span>', ['sessao/create', 'id' => $model->Paciente_id], [
                            'title' => Yii::t('yii', 'Adicionar Sessão'),
                    ]);   
                  },
                    'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['sessao/all', 'id' => $model->Paciente_id], [
                            'title' => Yii::t('yii', 'Visualizar Todas as Sessões'),
                    ]);   
                  }
              ]                            
            ],
        ],
    ]); ?>
</div>
