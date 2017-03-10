<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Paciente;
use app\models\Agenda;
use app\models\Consultorio;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Sessao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sessao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $items = ArrayHelper::map(Paciente::find()->all(), 'id', 'nome');
        echo $form->field($model, 'Paciente_id', ['readyOnly' => true])->dropDownList($items, ['prompt' => 'Selecione um Paciente'])
    ?>
    
    <?php 

    $dataCategory=ArrayHelper::map(Consultorio::find()->all(), 'id', 'nome');
        echo $form->field($model, 'Consultorio_id')->dropDownList($dataCategory, 
             ['prompt'=>'Selecione um Consultório',
              'onchange'=>'
                $.post( "'.Url::to('index.php?r=sessao/datas&consultorio=').'"+$(this).val(), function( data ) {
                  $( "select#data_inicio" ).html( data );
                });
            ']);

    $dataPost=ArrayHelper::map(Agenda::find()->where('id = -999')->all(), 'id', 'data_inicio');
        echo $form->field($model, 'data')
            ->dropDownList(
                $dataPost,           
                ['prompt'=>'Selecione um Dia', 'id'=>'data_inicio',]
        );
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
