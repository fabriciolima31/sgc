<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Disciplina;
use app\models\User;
use app\models\Turma;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TurmaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Turmas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turma-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Criar Nova Turma', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['label'=>'Código',
            'attribute' => 'codigo',
            ],
            [
                'label'=>'Semestre Letivo',
                'attribute' => 'semestre',
                'filter'=> array('1' => '1º Semestre', '2' => '2º Semestre'),
                'value' => function ($model) {
                        if($model->semestre == 1){
                            return "1º Semestre";
                        }
                        else{
                            return "2º Semestre";
                        }

                },

            ],
            ['label'=>'Ano',
            'attribute' => 'ano',
            'filter' => array(date('Y') => date('Y'), date('Y')-1 => date('Y')-1,date('Y')-2 => date('Y')-2, date('Y')-3 => date('Y')-3, date('Y')-4 => date('Y')-4),

            ],
            //'data_inicio',
            // 'data_fim',
             //'Disciplina_id',

             [  'label' => 'Disciplina',
                'attribute' => 'Disciplina_id',
                'filter'=> ArrayHelper::map(Disciplina::find()->all(), 'id', 'nome'),
                'value' => function ($model) {
                        $disciplina = ArrayHelper::map(Disciplina::find()->all(), 'id', 'nome');
                        return $disciplina[$model->Disciplina_id];

                },
            ],
             [  'label' => 'Professor',
                'attribute' => 'Professor_id',



                'filter' => Html::activeDropDownList($searchModel, 'Professor_id', 
                                    ArrayHelper::map(User::find()->select("Usuarios.nome, Usuarios.id")->where(["tipo" => 1])->orderBy("Usuarios.nome ASC")->all(), 'id', 'nome'),
                        ['class'=>'form-control','prompt' => '']),
                

                    'value' => function ($model) {
                        
                        return $model->nome_do_usuario;

                },
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
