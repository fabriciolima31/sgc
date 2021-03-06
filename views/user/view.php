<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = Yii::$app->user->identity->tipo == '4' ? ['label' => 'Usuários', 'url' => ['index']] : "";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::$app->user->id == $model->id ? Html::a('Editar Dados', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) : "" ?>
        <?= Yii::$app->user->id == $model->id ?  Html::a('Editar Senha', ['updatesenha', 'id' => $model->id], ['class' => 'btn btn-info']) : "" ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nome',
            'cpf',
            'email',
            ['label' =>'Perfil',
            'attribute' => 'tipo',
                'value' => function ($model){
                    $array_perfil = array(1 => "Professor" , 2 => "Psicólogo", 3 => "Aluno Terapeuta" , 4 => "Estagiário Administrativo");
                    return $array_perfil[$model->tipo];
                }
            ],

        ],
    ]) ?>

</div>
