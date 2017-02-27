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

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'ano')->widget(etsoft\widgets\YearSelectbox::classname(), [
        'yearStart' => 0,
        'yearEnd' => -2,
     ]);
    ?>

    <?php
        echo $form->field($model, 'semestre')->dropDownList(['1' => '1º Semestre', '2' => '2º Semestre'],['prompt'=>'Selecione uma opção']);
    ?>

<?php echo $form->field($model, 'data_inicio')->widget(
        'trntv\yii\datetime\DateTimeWidget',
        ['phpDatetimeFormat' => 'dd/MM/yyyy']
    ); 
?>



<?php echo $form->field($model, 'data_fim')->widget(
        'trntv\yii\datetime\DateTimeWidget',
        ['phpDatetimeFormat' => 'dd/MM/yyyy']
    ); 
?>

<?php 
    $items = ArrayHelper::map(Disciplina::find()->all(), 'id', 'nome');
    echo $form->field($model, 'Disciplina_id')->dropDownList($items)
?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
