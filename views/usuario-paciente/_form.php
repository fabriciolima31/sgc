<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;

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
        //$items = ArrayHelper::map(User::find()->where(['tipo' => '3', 'status' => 1])->orWhere(['tipo' => '2'])->all(), 'id', 'nome');
        
        $items = ArrayHelper::map(User::find()->select('Usuarios.id, Usuarios.nome')->innerJoin('Aluno_Turma', 'Usuarios_id = Usuarios.id')
                ->innerJoin('Turma', 'Turma_id = Turma.id')->where('data_fim > CURDATE()')->orderBy('Usuarios.nome')->all(), 'id', 'nome');
        
        echo $form->field($model, 'Usuario_id')->dropDownList($items, ['prompt' => 'Selecione um Terapeuta'])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Alocar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' , 'disabled' => ($existe_usuario_paciente > 0)]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
