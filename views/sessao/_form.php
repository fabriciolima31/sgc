<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Paciente;
use app\models\Consultorio;

/* @var $this yii\web\View */
/* @var $model app\models\Sessao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sessao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $items = ArrayHelper::map(Paciente::find()->all(), 'id', 'nome');
        echo $form->field($model, 'Paciente_id')->dropDownList($items, ['prompt' => 'Selecione um Paciente'])
    ?>
    
    <?php 
        $items = ArrayHelper::map(Consultorio::find()->all(), 'id', 'nome');
        echo $form->field($model, 'Consultorio_id')->dropDownList($items, ['prompt' => 'Selecione um Consultório'])
    ?> 

    <?= $form->field($model, 'data')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'horario')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'status')->dropDownList(['EE' => 'Em Espera', 'NC' => 'Não Ocorrida', 'OS' => 'Ocorrida']) //Leitura para create e escirta para update ?>   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
