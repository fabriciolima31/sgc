<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Consultorio */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Consultorios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultorio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Remover', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Deseja remover o consultório selecionado?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'nome',
        ],
    ]) ?>

</div>
