<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sessao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sessao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Paciente_id')->textInput() ?>

    <?= $form->field($model, 'Usuarios_id')->textInput() ?>

    <?= $form->field($model, 'Consultorio_id')->textInput() ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
