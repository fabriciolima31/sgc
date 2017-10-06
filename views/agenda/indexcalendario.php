<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Agenda;
use yii\web\JsExpression;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $searchModel app\models\AgendaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$agenda = new Agenda();
$agendaDependencias = $agenda->dependenciasAgendamento();

    if ($agendaDependencias != []){ ?>
        <div class="alert alert-danger" style="text-align: center">
            Atenção: <strong> Requisitos insuficientes para criar agendamento. Cadastre ou ative os seguintes itens: <?= implode(', ', $agendaDependencias) ?>. </strong>
        </div>
    <?php }


$this->title = 'Reservas dos Consultórios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agenda-index">

    <h1><?= Html::encode($this->title)?></h1>
    
    <script type="text/javascript">
      function anoSelecionado(){
          var x = document.getElementById("comboBoxAno").value;
          window.location="index-calendario?idConsultorio="+x; 
      }
    </script>

    <p>
        <!-- Yii::$app->user->identity->tipo == '4' ? Html::a('Criar Reserva', ['create'], ['class' => 'btn btn-success']) : "" ?> -->
    </p>
    
    <?php
      Modal::begin([
        'header' => '<h2>Reserva de Consultório</h2>',
        'id' => 'modal',
        'size' => 'modal-lg',
      ]);
      echo "<div id='modalContent'>Carregando....</div>";
      Modal::end();
    ?>
    
    <div class='col-md-12'>
     <p class='col-md-6'>
      <b>Selecione um Consultório:</b> <select id= "comboBoxAno" onchange="anoSelecionado();" class="form-control">
          <?php for($i=0; $i<count($modelConsultorio); $i++){ 
              $valores = $modelConsultorio[$i]->id;
              ?>
              <option value='<?= $modelConsultorio[$i]->id?>' <?php if($modelConsultorio[$i]->id == $_GET["idConsultorio"]){echo "SELECTED";} ?> > <?php echo $modelConsultorio[$i]->nome ?> </option>
          <?php } ?>
        </select>
      </p>
    </div>

    
    <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
        'options' => [
            'lang' => 'pt-br',
        ],
        'clientOptions' => [
          'header' => ['right' => 'month, agendaWeek, agendaDay, listMonth'],
            'minTime' => '08:00:00',
            'maxTime' => '20:01:00',
            'allDaySlot' => false,
            'dayClick' => new JsExpression("function(date, jsEvent, view) {
              var currentDate = (new Date()).toISOString().slice(0, 10);
              var dateStr = date;
              var data = (new Date(dateStr)).toISOString().slice(0, 10);
              var hora = (new Date(dateStr)).toISOString().slice(11, 16);
              
              //var idevento = getParameterByName('idevento');
              
              if(data < currentDate){
                alert('Data inválida. Informe uma data posterior a '+currentDate);
                //location.reload();
              }else{
              
                alert('UMA DATA VALIDA');
                
                /*Planejar AJAX*/
              }
              
            }"),
            'eventClick' => new JsExpression("function(calEvent, jsEvent, view) {
              if(calEvent.id)
                $.get('view', {'id': calEvent.id, 'requ': 'AJAX'}, function(data){
                      $('#modal').modal('show')
                      .find('#modalContent')
                      .html(data);
                  });
              else{
                var titulo = calEvent.title;
                var dateStr = calEvent.start._d;
                if(calEvent.end != null){
                  var dateStr2 = calEvent.end._d
                  var horaFim = (new Date(dateStr2)).toISOString().slice(11, 16);
                }else
                  var horaFim = null;
                var data = (new Date(dateStr)).toISOString().slice(0, 10);
                var hora = (new Date(dateStr)).toISOString().slice(11, 16);
                if(data < (new Date()).toISOString().slice(0, 10)){
                  alert('Data inválida. Informe um data futura');
                  return false;
                }
                var idevento = getParameterByName('idevento');
                $.get('index.php?r=item-programacao/create', {'data': data, 'hora': hora, 'horafim': horaFim, 'idevento': idevento, 'titulo': titulo, 'requ': 'AJAX'}, function(data){
                  $('#modal').modal('show')
                  .find('#modalContent')
                  .html(data);
                });
              }
            }"),],
        'events'=> $reservas,
        ));
    ?>
</div>
