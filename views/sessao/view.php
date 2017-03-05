<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sessao */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sessaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sessao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Remover', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você tem certeza que deseja remover esta sessão?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'Paciente_id',
            //'Usuarios_id',
            'Consultorio_id',
            'Agenda_id',
            //'horario',
        ],
    ]) ?>

</div>
