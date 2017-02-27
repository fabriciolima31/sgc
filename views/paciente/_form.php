<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paciente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'horario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sexo')->dropDownList(['M' => 'Masculino', 'F' => 'Feminino'],['prompt'=>'Selecione uma Opção']); ?>
    
    <?= $form->field($model, 'data_nascimento')->widget(MaskedInput::className(), [
    'mask' => '99/99/9999',]) ?>
    
    <?= $form->field($model, 'telefone')->widget(MaskedInput::className(), [
    'mask' => '99999-9999',]) ?>

    <?= $form->field($model, 'endereco')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'moradia')->textInput() ?>

    <?= $form->field($model, 'turno_atendimento')->dropDownList(['M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite'],['prompt'=>'Selecione uma Opção']); ?>

    <?= $form->field($model, 'local_encaminhamento')->textInput() ?>

    <?= $form->field($model, 'local_terapia')->textInput() ?>

    <?= $form->field($model, 'motivo_psicoterapia')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'servico')->textInput() ?>

    <?= $form->field($model, 'observacao')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
