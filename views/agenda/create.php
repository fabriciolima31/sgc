<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Agenda */

$this->title = 'Criar Reserva';
$this->params['breadcrumbs'][] = ['label' => 'Reservas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agenda-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 

    if (!isset($dadosConflituosos)){
    	$dadosConflituosos = null;
    }

    if (!isset($diaSemanaArray)){
    	$diaSemanaArray = null;
    }
    else{
    	$model->diaSemanaArray = $diaSemanaArray;
    }

    ?>

    <?= $this->render('_form', [
        'model' => $model,
        'dadosConflituosos' => $dadosConflituosos,
    ]) ?>

</div>
