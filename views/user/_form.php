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

    <?php 
        if($this->context->action->id == 'update'){
            echo $form->field($model, 'cpf')->textInput(['readonly'=>true]);
        }
    ?>

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
  
    <?= $form->field($model, 'tipo')->dropDownList(['1' => 'Professor', '2' => 'Psicólogo', 
        '3' => 'Aluno Terapeuta', '4' => 'Estagiário Administrativo'], ['prompt'=>'Selecione um Perfil ']); ?>

    <div id="checkBoxDeTurmas" style="width: 30%; border: solid 1px lightgray; padding: 2px 1px 0px 4px; margin-bottom: 1%; display: none">
        <?php 
            $turmas = Turma::find()->select("Disciplina.nome as nome_da_disciplina, Turma.*")->innerJoin("Disciplina","Disciplina.id = Turma.Disciplina_id")->all();

            if ($turmas == null){
                echo "<div style='color:red'> Obs.: Não há Turmas Cadastradas. </div>";
            }
            else{
            echo $form->field($model, 'turmasArray')
            ->checkboxList(ArrayHelper::map($turmas,'id',                      
                function($model, $defaultValue) {
                        return $model['nome_da_disciplina'].' - Turma: '.$model['codigo'];
                }

            )); 
            }

        ?>
    </div>
  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<head>

<script type="text/javascript">

var selecao = document.getElementById("user-tipo").onchange = displayDate;
 window.onload = displayDate;

function displayDate() {

    if (document.getElementById("user-tipo").value == 3){

            $('#checkBoxDeTurmas').css({
                'display': 'block',
            });

    }
    else{
            $('#checkBoxDeTurmas').css({
                'display': 'none',
            });        
    }
}
    
    displayDate();
 

</script>

</head>