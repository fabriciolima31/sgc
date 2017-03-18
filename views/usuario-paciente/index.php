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
                'label' => 'Terapeuta',
                'value' => 'usuario.nome',
            ],
            [
                'label' => 'Paciente Status',
                'value' => 'paciente.statusDesc',
            ],

            ['class' => 'yii\grid\ActionColumn',
              'template'=>'{encaminharLE}  {encaminharOT}',
                'buttons'=>[
                    'encaminharLE' => function ($url, $model) {  
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['usuario-paciente/encaminhar', 'id' => $model->Paciente_id], [
                                'title' => Yii::t('yii', 'Encaminhar para fila de Espera'),
                        ]);                                
                    },
                    'encaminharOT' => function ($url, $model) {  
                        return Html::a('<span class="glyphicon glyphicon-user"></span>', ['usuario-paciente/encaminhar-terapeuta', 'id' => $model->Paciente_id], [
                            'data' => [
                                'confirm' => 'Deseja Alocar o paciente \''.$model->paciente->nome.'\' para outro terapeuta?',
                            ],
                                'title' => Yii::t('yii', 'Encaminhar para outro Terapeuta'),
                        ]);                                
                    },
              ]                            
            ],
        ],
    ]); ?>
</div>
