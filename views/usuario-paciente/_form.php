<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\UsuarioPaciente;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioPaciente */
/* @var $form yii\widgets\ActiveForm */

if ($existe_usuario_paciente > 0){
	?>
	<div class="alert alert-danger" style="text-align: center">
        Atenção: <strong> Esse Paciente já está alocado para um Terapeuta! </strong>
    </div>
    <?php
}

?>

<div class="usuario-paciente-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php 
        echo $form->field($model, 'Usuario_id')->dropDownList($terapeutas, ['prompt' => 'Selecione um Terapeuta'])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Alocar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' , 'disabled' => ($existe_usuario_paciente > 0)]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<h1> Histórico de Alocacões desse Paciente </h1>
        
        <table class="table" style="margin-top:2%">
            <tr>
                <th> Terapeuta </th>
                <th>  Justificativa </th>
            </tr>

<?php
    if(count($historicoTerapeutasAnterioresAoPaciente)){
?>
                <?php 
                        for($i=0; $i<count($historicoTerapeutasAnterioresAoPaciente); $i++){
                ?>
            <tr>
                    <td> <?= $historicoTerapeutasAnterioresAoPaciente[$i]['nome_do_terapeuta'] ?> </td>
                    <td> <?= $historicoTerapeutasAnterioresAoPaciente[$i]['observacao'] ?> </td>
            </tr>
                <?php 
                        }

                ?>
<?php
    }
    else{
        echo "<tr style='color:red'> <td> Não há alocações anteriores </td> </tr>";
    }
?>
        </table>
