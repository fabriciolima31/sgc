<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioPaciente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-paciente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Paciente_id')->textInput(['maxlength' => true]) ?>
    
    <?php 
        $items = ArrayHelper::map(User::find()->where(['tipo' => '3', 'status' => 1])->all(), 'id', 'nome'); //Ver para pegar o Psicologo ou professor
        echo $form->field($model, 'Usuario_id')->dropDownList($items, ['prompt' => 'Selecione um Terapeuta'])
    ?>    
    
    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
