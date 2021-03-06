<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AgendaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agenda-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'Consultorio_id') ?>

    <?= $form->field($model, 'Usuarios_id') ?>

    <?= $form->field($model, 'diaSemana') ?>

    <?= $form->field($model, 'horaInicio') ?>

    <?php // echo $form->field($model, 'horaFim') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'data_inicio') ?>

    <?php // echo $form->field($model, 'data_fim') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
