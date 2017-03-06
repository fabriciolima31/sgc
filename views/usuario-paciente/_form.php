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
    
    <?php 
        $items = ArrayHelper::map(User::find()->where(['tipo' => '3', 'status' => 1])->orWhere(['tipo' => '2'])->all(), 'id', 'nome'); //Ver para pegar o Psicologo ou professor
        echo $form->field($model, 'Usuario_id')->dropDownList($items, ['prompt' => 'Selecione um Terapeuta'])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
