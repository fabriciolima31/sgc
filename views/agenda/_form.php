<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Consultorio;
use app\models\User;
use kartik\datecontrol\DateControl;
use dosamigos\datepicker\DatePicker;




/* @var $this yii\web\View */
/* @var $model app\models\Agenda */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 

    if (isset($dadosConflituosos) && $dadosConflituosos != null){


    function build_table($array){

    $array_semanas = array([0 => "Domingo" , 1 => 'Segunda-Feira', 2 => 'Terça-Feira', 3 => 'Quarta-Feira', 4 => 'Quinta-Feira', 5 => 'Sexta-Feira', 6 => 'Sábado' ]);

        // start table
        $html = '<table class ="table" style="border:solid 1px lightgray">';
        // header row
        $html .= '<tr>';
        foreach($array[0] as $key=>$value){
                $html .= '<th>' . $key . '</th>';
            }
        $html .= '</tr>';

        // data rows
        foreach( $array as $key=>$value){
            $html .= '<tr>';
            foreach($value as $key2=>$value2){
                if($key2 == "diaSemana"){
                    $value2 = $array_semanas[0][$value2];
                }

                $html .= '<td>' . $value2 . '</td>';
            }
            $html .= '</tr>';
        }

        // finish table and return it

        $html .= '</table>';
        return $html;
    }
    ?>
    <div class="alert alert-danger" style="text-align: center">
        Atenção: <strong>Não foi possível SALVAR o agendamento, tendo em vista os conflitos de dias e horários, conforme lista abaixo. </strong>
    </div>
    <?php

       echo (build_table($dadosConflituosos));
    ?>

    <div class="alert alert-danger" style="text-align: center">
        Atenção: <strong> Escolha Dias ou Horários diferentes dos descritos na tabela acima </strong>
    </div>

    <?php
    }

?>

<div class="agenda-form">

    <?php $form = ActiveForm::begin(); ?>

<?php 
    $items = ArrayHelper::map(Consultorio::find()->where(['status' => '1'])->all(), 'id', 'nome');
    echo $form->field($model, 'Consultorio_id')->dropDownList($items,['prompt' => 'Selecione um Consultório']);
?>

<?php 
    $items = ArrayHelper::map(User::find()->where(['tipo' => 3])->all(), 'id', 'nome');
    echo $form->field($model, 'Usuarios_id')->dropDownList($items,['prompt' => 'Selecione um Usuário']);
?>

    <div style="border: solid 1px lightgray; padding: 2px 1px 0px 4px; margin-bottom: 1%">
<?php echo $form->field($model, 'diaSemanaArray')->checkboxList(['0' => "Domingo" , '1' => 'Segunda-Feira', '2' => 'Terça-Feira', '3' => 'Quarta-Feira', '4' => 'Quinta-Feira', '5' => 'Sexta-Feira', '6' => 'Sábado' ]); ?>
    </div>

        <?php

            echo $form->field($model, 'horaInicio', ['options' => []])->widget(DateControl::classname(), [
            'language' => 'pt-BR',
            'name'=>'kartik-date',
            'type'=>DateControl::FORMAT_TIME,
            'displayFormat' => 'php: H:i',
        ])->label("<font color='#FF0000'>*</font> <b>Hora de Início:</b>");

            echo $form->field($model, 'horaFim', ['options' => []])->widget(DateControl::classname(), [
            'language' => 'pt-BR',
            'name'=>'kartik-date',
            'type'=>DateControl::FORMAT_TIME,
            'displayFormat' => 'php: H:i',
        ])->label("<font color='#FF0000'>*</font> <b>Hora de Fim:</b>");

        ?>


    <?= $form->field($model,'data_inicio')->widget(DatePicker::className(),
    [    'language' => 'pt',

        'clientOptions' => ['format' => 'dd-mm-yyyy']
    ]) ?>


    <?= $form->field($model,'data_fim')->widget(DatePicker::className(),
    [    'language' => 'pt',

        'clientOptions' => ['format' => 'dd-mm-yyyy']
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Editar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<head>  

<script type="text/javascript">

    //gambiarra
    if(document.getElementById("agenda-horainicio-disp").value == ''){
        document.getElementById("agenda-horainicio-disp").value = 0;
        document.getElementById("agenda-horafim-disp").value = 0;
    }

</script>


</head>