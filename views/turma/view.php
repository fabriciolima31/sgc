<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\Disciplina;

/* @var $this yii\web\View */
/* @var $model app\models\Turma */

$this->title = $model->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Turmas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turma-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Remover', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você tem certeza que deseja REMOVER este item ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'codigo',
            ['label'=>'Disciplina',
                'attribute' => 'Disciplina_id',
                'value' => function ($model){

                $disciplina = ArrayHelper::map(Disciplina::find()->all(), 'id', 'nome');
                return $disciplina[$model->Disciplina_id];
                },
            ],
            'semestre',
            'ano',
            'data_inicio',
            'data_fim',
           
        ],
    ]) ?>

</div>
