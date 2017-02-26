<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuários';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Usuário', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            'cpf',
            'nome',
             [  'label' => 'Perfil',
                'attribute' => 'tipo',
                'filter'=>array("1"=>"Professor","2"=>"Psicólogo", "3" => "Terapeuta", "4" => "Adminstrador"),
                'value' => function ($model) {
                     if($model->tipo == 1){
                         return 'Professor';
                     }else if($model->tipo == 2){
                         return "Psicólogo";
                     }else if($model->tipo == 3){
                         return "Terapeuta";
                     }else{
                         return "Administrador";
                     }
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
