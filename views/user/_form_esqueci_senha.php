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

<div class = "login-box">
	<div class = "login-box-body">
		<div class ="login-box-msg">
			<h3 style="color:blue"> Esqueci Minha Senha. </h3>
			<small style="color:red"> Digite seu CPF e clique em Solicitar Nova Senha. </small>
		</div>
		<div class="user-form" >

		    <?php $form = ActiveForm::begin(); ?>

		    <?php 
		            echo $form->field($model, 'cpf')->widget(MaskedInput::className(), [
		            'mask' => '999.999.999-99',]);

		    ?>

		    <div class="form-group">
		        <?= Html::submitButton('Solicitar Nova Senha', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>

		</div>
	</div>
</div>
