<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Disciplina;

/* @var $this yii\web\View */
/* @var $model app\models\Turma */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="turma-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ano')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'semestre')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'Disciplina_id')->textInput() ?>

    <?php 
        $items = ArrayHelper::map(Disciplina::find()->all(), 'id', 'nome');
        echo $form->field($model, 'Disciplina_id')->dropDownList($items)
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
