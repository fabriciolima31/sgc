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

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Nome:</b>"); ?>

    <?= $form->field($model, 'sexo')->dropDownList(['M' => 'Masculino', 'F' => 'Feminino'],['prompt'=>'Selecione uma Opção'])->label("<font color='#FF0000'>*</font> <b>Sexo:</b>");; ?>
    
    <?= $form->field($model, 'data_nascimento')->widget(MaskedInput::className(), [
    'mask' => '99/99/9999',])->label("<font color='#FF0000'>*</font> <b>Data de Nascimento:</b>"); ?>
    
    <?= $form->field($model, 'telefone')->widget(MaskedInput::className(), [
    'mask' => '99999-9999',])->label("<font color='#FF0000'>*</font> <b>Telefone:</b>"); ?>

    <?= $form->field($model, 'endereco')->textInput(['maxlength' => true])->label("<font color='#FF0000'>*</font> <b>Endereço:</b>"); ?>

    <?= $form->field($model, 'moradia')->textInput()->label("<font color='#FF0000'>*</font> <b>Com que mora?</b>"); ?>

    <?= $form->field($model, 'turno_atendimento')->dropDownList(['M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite'],['prompt'=>'Selecione uma Opção'])->label("<font color='#FF0000'>*</font> <b>Turno para Atendimento:</b>"); ?>

    <?= $form->field($model, 'local_encaminhamento')->textInput()->label("<b>De onde veio encaminhado?</b>"); ?>

    <?= $form->field($model, 'local_terapia')->textInput()->label("<b>Qual o local onde já realizou terapia?</b>"); ?>

    <?= $form->field($model, 'motivo_psicoterapia')->textarea(['rows' => 6])->label("<font color='#FF0000'>*</font> <b>Por que gostaria de fazer psicoterapia?</b>"); ?>

    <?= $form->field($model, 'servico')->textInput()->label("<font color='#FF0000'>*</font> <b>Como soube do serviço?</b>"); ?>

    <?= $form->field($model, 'observacao')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
