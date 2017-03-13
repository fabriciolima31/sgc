<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Relatorio;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar Dados', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Editar Senha', ['updatesenha', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Remover', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você tem certeza que deseja REMOVER este usuário: \''.$model->nome.'\'?',
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

    <?php
    



    ?>

</div>
