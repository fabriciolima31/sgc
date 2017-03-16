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

<div style="color:blue"> Digite o seu CPF para recuperar sua senha e clique em solicitar nova senha. </div>
<br>
<div class="user-form">

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
