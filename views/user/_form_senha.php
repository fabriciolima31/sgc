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
            echo $form->field($model, 'nome')->textInput(['maxlength' => true, 'readonly' => true]);
            echo $form->field($model, 'cpf')->textInput(['readonly'=>true]);
            echo $form->field($model, 'password')->passwordInput(['maxlength' => true]);
            echo $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]);

    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar Senha' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
