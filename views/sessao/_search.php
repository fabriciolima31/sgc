<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SessaoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sessao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'Paciente_id') ?>

    <?= $form->field($model, 'Usuarios_id') ?>

    <?= $form->field($model, 'Consultorio_id') ?>

    <?= $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'horario') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
