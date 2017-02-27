<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Remover', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Remover usuário \''.$model->nome.'\'?',
                'method' => 'post',
            ],
        ]) ?>
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
