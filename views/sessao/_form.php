<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Agenda;
use app\models\Consultorio;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Sessao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sessao-form">
    
    <?php 

    if($quantidadeAgendamentosVagos == 0){
        echo '<div class="alert alert-danger" style="text-align: center">
            Atenção: <strong> Você não possui agendamentos, não será possível, portanto, criar uma Sessão. <br> Solicite ao administrador a criação de um agendamento. </strong>
        </div>';
    }
    else{

        $form = ActiveForm::begin();

            $dataCategory=ArrayHelper::map(Consultorio::find()->all(), 'id', 'nome');
                echo $form->field($model, 'Consultorio_id')->dropDownList($dataCategory, 
                     ['prompt'=>'Selecione um Consultório',
                      'onchange'=>'
                        $.post( "'.Url::to('/web/sessao/datas?consultorio=').'"+$(this).val(), function( data ) {
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
                <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'disabled' => $quantidadeAgendamentosVagos == 0]) ?>
            </div>

        <?php ActiveForm::end(); 

    }

    ?>

</div>
