<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Consultorio;
use app\models\Turma;
use app\models\User;
use kartik\datecontrol\DateControl;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use kartik\select2\Select2;
use app\models\Agenda;

$agenda = new Agenda();
$agendaDependencias = $agenda->dependenciasAgendamento();


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

    <?php if ($agendaDependencias != []){ ?>
        <div class="alert alert-danger" style="text-align: center">
            Atenção: <strong> Requisitos insuficientes para criar agendamento. Cadastre ou ative os seguintes itens: <?= implode(', ', $agendaDependencias) ?>. </strong>
        </div>
    <?php }else{ ?>
    
    <?php $form = ActiveForm::begin(); ?>

<?php 
    $items = ArrayHelper::map(Consultorio::find()->where(['status' => '1'])->all(), 'id', 'nome');
    echo $form->field($model, 'Consultorio_id')->dropDownList($items,['prompt' => 'Selecione um Consultório'])
            ->label("<font color='#FF0000'>*</font> <b>Consultório:</b>");
?>

<?php

    $usuarios=ArrayHelper::map(User::find()->where(['tipo' => 3, 'status' => '1'])->all(), 'id', 'nome');
        echo
        $form->field($model, 'Usuarios_id')->widget(Select2::classname(), [
            'data' => $usuarios,
            'language' => 'pt',
            'options' => ['placeholder' => 'Selecione um Aluno', 
                'onchange'=>'
                $.post( "'.Url::to('/web/agenda/turmas?id_terapeuta=').'"+$(this).val(), function( data ) {
                  $( "select#agenda-turma_id" ).html( data );
                });'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label("<font color='#FF0000'>*</font> <b>Terapeuta:</b>");
?>

    <?php 
        $turmas = Turma::find()->select("Disciplina.nome as nome_da_disciplina, Turma.*")->innerJoin("Disciplina","Disciplina.id = Turma.Disciplina_id")->where(["Turma.id" => -9999])->all();
        echo $form->field($model, 'Turma_id')
        ->dropDownList(ArrayHelper::map($turmas,'id',                      
            function($model, $defaultValue) {
                    return $model['nome_da_disciplina'].' - Turma: '.$model['codigo'];
            }

        ),['prompt'=>'Escolha uma Disciplina e Turma',
            'onMouseOver'=>'
            $.post( "'.Url::to('/web/agenda/turmas?id_terapeuta=').'"+$("select#agenda-usuarios_id").val(), function( data ) {
               var x = $( "select#agenda-turma_id").val();
                if(x == null || x == ""){
                 $( "select#agenda-turma_id" ).html( data );
                }
            });',
        ])->label("<font color='#FF0000'>*</font> <b>Disciplina/Turma:</b>"); 


    ?>

    <div style="border: solid 1px lightgray; padding: 2px 1px 0px 4px; margin-bottom: 1%">
<?php echo $form->field($model, 'diaSemanaArray')->checkboxList(['0' => "Domingo" , '1' => 'Segunda-Feira', '2' => 'Terça-Feira', '3' => 'Quarta-Feira', '4' => 'Quinta-Feira', '5' => 'Sexta-Feira', '6' => 'Sábado' ])
        ->label("<font color='#FF0000'>*</font> <b>Dia da Semana:</b>"); ?>
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
    ])->label("<font color='#FF0000'>*</font> <b>Data de Início:</b>") ?>


    <?= $form->field($model,'data_fim')->widget(DatePicker::className(),
    [    'language' => 'pt',

        'clientOptions' => ['format' => 'dd-mm-yyyy']
    ])->label("<font color='#FF0000'>*</font> <b>Data de Fim:</b>") ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Editar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
    <?php } ?>
<head>  

<script type="text/javascript">


    if(document.getElementById("agenda-horainicio-disp").value == ''){
        document.getElementById("agenda-horainicio-disp").value = 0;
        document.getElementById("agenda-horafim-disp").value = 0;
    }

</script>


</head>