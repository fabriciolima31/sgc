<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Turma;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioTurma */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-turma-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $items = ArrayHelper::map(Turma::find()->all(), 'id', 'descricao');
        echo $form->field($model, 'Turma_id')->dropDownList($items)
    ?>

    <?php 
        $items = ArrayHelper::map(User::find()->all(), 'id', 'nome');
        echo $form->field($model, 'Usuarios_id')->dropDownList($items)
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
