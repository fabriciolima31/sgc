<?php

use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Turma;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">



    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?php 
        // quando a ACTION for create, vai aparecer os dois formulários abaixo. No caso do update, estes dois campos ficam ocultos.
        if($this->context->action->id == 'create'){
            echo $form->field($model, 'cpf')->widget(MaskedInput::className(), [
            'mask' => '999.999.999-99',]);
            echo $form->field($model, 'password')->passwordInput(['maxlength' => true]);
            echo $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]);
        }
    ?>

    <?php 
        if($this->context->action->id == 'update'){
            echo $form->field($model, 'cpf')->textInput(['readonly'=>true]);
        }
    ?>
  
    <?= $form->field($model, 'tipo')->dropDownList(['1' => 'Professor', '2' => 'Psicólogo', 
        '3' => 'Aluno Terapeuta', '4' => 'Estagiário Administrativo'], ['prompt'=>'Selecione um Perfil ']); ?>
  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
