<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Consultorio;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paciente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'Consultorio_id')->textInput() ?>

    <?php 
        $items = ArrayHelper::map(Consultorio::find()->all(), 'id', 'nome');
        echo $form->field($model, 'Consultorio_id')->dropDownList($items)
    ?>

    <?= $form->field($model, 'horario')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'sexo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sexo')->dropDownList(['M' => 'Masculino', 'F' => 'Feminino'],['prompt'=>'Selecione uma Opção']); ?>

    <?= $form->field($model, 'data_nascimento')->textInput() ?>

    <?= $form->field($model, 'telefone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endereco')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'moradia')->textarea(['rows' => 6]) ?>

    <?php //echo $form->field($model, 'turno_atendimento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'turno_atendimento')->dropDownList(['M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite'],['prompt'=>'Selecione uma Opção']); ?>

    <?= $form->field($model, 'local_encaminhamento')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'local_terapia')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'motivo_psicoterapia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'servico')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'observacao')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
