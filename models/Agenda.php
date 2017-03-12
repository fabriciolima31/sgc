<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Agenda".
 *
 * @property integer $id
 * @property integer $Consultorio_id
 * @property integer $Usuarios_id
 * @property string $diaSemana
 * @property string $horaInicio
 * @property string $horaFim
 * @property string $status
 * @property string $data_inicio
 * @property string $data_fim
 *
 * @property Consultorio $consultorio
 * @property Usuarios $usuarios
 * @property Paciente[] $pacientes
 */
class Agenda extends \yii\db\ActiveRecord
{

    public $diaSemanaArray;
    private $horarioInicialAtendimento = "08:00";
    private $horarioFinalAtendimento = "20:00";
    public $numerica;
    public $dadosConflituosos;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Agenda';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Consultorio_id', 'Usuarios_id', 'horaInicio', 'horaFim','diaSemanaArray', 'Turma_id'], 'required'],
            [['diaSemana','Consultorio_id', 'Usuarios_id' ,'Turma_id'], 'integer'],
            [['diaSemanaArray','horaInicio', 'horaFim', 'data_inicio', 'data_fim'], 'safe'],
            [['horaInicio'], 'validateHoraIni'],
            [['horaFim'], 'validateHoraFim'],
            [['data_inicio'], 'validateDateIni'],
            [['data_fim'], 'validateDateFim'],
            [['status'], 'string', 'max' => 1],
            [['Consultorio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consultorio::className(), 'targetAttribute' => ['Consultorio_id' => 'id']],
            [['Usuarios_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['Usuarios_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Consultorio_id' => 'Consultorio',
            'Usuarios_id' => 'Usuário',
            'horaInicio' => 'Hora Inicio',
            'horaFim' => 'Hora Fim',
            'status' => 'Status',
            'data_inicio' => 'Data Inicio',
            'data_fim' => 'Data Fim',
            'diaSemanaArray' => 'Dia da Semana',
            'Turma_id' => 'Disciplina/Turma',
        ];
    }
    
        /*Funções para validação de atributos*/
    public function validateDateIni($attribute, $params, $validator){
        if (!$this->hasErrors()) {

            $date1= $this->data_inicio;
            $date2= date('d-m-Y');

        if (strtotime($date1) < strtotime($date2)) {
                $this->addError($attribute, 'Informe uma data igual ou posterior a '.date('d-m-Y'));
                //$validator->addError($this, $attribute, 'The value "{value}" is not acceptable for {attribute}.');
            }
        }

    }
    public function validateDateFim($attribute, $params, $validator){
        if (!$this->hasErrors()) {

            $date1= $this->data_inicio;
            $date2= $this->data_fim;

            if (strtotime($date2) < strtotime($date1)) {
                $this->addError($attribute, 'Informe uma data igual ou posterior a '.date("d-m-Y", strtotime($this->data_inicio)));
            }
        }
    }


    public function validateHoraIni($attribute, $params, $validator){
        if (!$this->hasErrors()) {

            $hora1= date('H:i',strtotime($this->horaInicio));
            $hora2= date('H:i',strtotime($this->horaFim));

            if ($hora1 == $hora2){
                $this->addError($attribute, 'A hora inicial deve ser diferente da hora final');   
            }


            if ($hora1 < date('H:i', strtotime($this->horarioInicialAtendimento)) || $hora1 > date('H:i', strtotime($this->horarioFinalAtendimento)) ) {
                $this->addError($attribute, 'A hora inicial deve ter horário MAIOR ou IGUAL a 08:00 e MENOR OU IGUAL AS 20:00');
            }

        }

    }
    public function validateHoraFim($attribute, $params, $validator){
        if (!$this->hasErrors()) {

            $hora1= date('H:i',strtotime($this->horaInicio));
            $hora2= date('H:i',strtotime($this->horaFim));

            $horaLimiteMinimo =  date('H:i',strtotime($this->horaInicio) + 60*60);

            $diferencaDeMinutos = date('i', strtotime($this->horaFim) - strtotime($this->horaInicio) );

            if (strtotime($hora2) < strtotime($hora1)) {
                $this->addError($attribute, 'A hora final deve ser MAIOR que a hora inicial.');
            }
            if ($hora2 < date('H:i', strtotime($this->horarioInicialAtendimento)) || $hora2 > date('H:i', strtotime("21:00")) ) {

                $this->addError($attribute, 'A hora fim deve ter horário MAIOR ou IGUAL a 08:00 e MENOR OU IGUAL AS 21:00');

            }

            if($hora2 < $horaLimiteMinimo){
                $this->addError($attribute, 'A diferença entre a hora inicial e final deve ser de no mínimo 1 hora');                
            }

            if($diferencaDeMinutos != 0){
                $this->addError($attribute, "A diferença temporal entre Hora Inicial e Hora Final deve ser um inteiro de hora");
            }
        }
    }
    
    public function beforeSave($insert) {
        $this->converterDatas_para_AAAA_MM_DD();
        return true;
    }
    
    public function afterFind() {
        $this->converterDatas_para_DD_MM_AAAA();
        return true;
    }

    
    /* Conversão de Data*/
    public function converterDatas_para_AAAA_MM_DD() {

        $ano = substr($this->data_inicio,6,4); //pega os 4 ultimos caracteres, a contar do índice 4
        $mes = substr($this->data_inicio,3,2); //pega os 2 caracteres, a contar do índice 2
        $dia = substr($this->data_inicio,0,2); //pega os 2 caracteres, a contar do índice 0
        $this->data_inicio = $ano."-".$mes."-".$dia;
        
        $ano = substr($this->data_fim,6,4); //pega os 4 ultimos caracteres, a contar do índice 4
        $mes = substr($this->data_fim,3,2); //pega os 2 caracteres, a contar do índice 2
        $dia = substr($this->data_fim,0,2); //pega os 2 caracteres, a contar do índice 0
        $this->data_fim = $ano."-".$mes."-".$dia;
        
    }

    /*Conversão de Data*/
    public function converterDatas_para_DD_MM_AAAA() {

        $ano = substr($this->data_inicio,0,4); //pega os 4 ultimos caracteres, a contar do índice 4
        $mes = substr($this->data_inicio,5,2); //pega os 2 caracteres, a contar do índice 2
        $dia = substr($this->data_inicio,8,2); //pega os 2 caracteres, a contar do índice 0
        $this->data_inicio = $dia."-".$mes."-".$ano;
        
        $ano = substr($this->data_fim,0,4); //pega os 4 ultimos caracteres, a contar do índice 4
        $mes = substr($this->data_fim,5,2); //pega os 2 caracteres, a contar do índice 2
        $dia = substr($this->data_fim,8,2); //pega os 2 caracteres, a contar do índice 0
        $this->data_fim = $dia."-".$mes."-".$ano;
    }

        /*Conversão de Data*/
    public function converterDatas_para_AAAA_MM_DD_com_Retorno($data) {

        $ano = substr($data,6,4); //pega os 4 ultimos caracteres, a contar do índice 4
        $mes = substr($data,3,2); //pega os 2 caracteres, a contar do índice 2
        $dia = substr($data,0,2); //pega os 2 caracteres, a contar do índice 0
        return $ano."-".$mes."-".$dia;
      

    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultorio()
    {
        return $this->hasOne(Consultorio::className(), ['id' => 'Consultorio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'Usuarios_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
        return $this->hasMany(Paciente::className(), ['Agenda_id' => 'id']);
    }


    public function verificarConflitosNoInsert ($horaInicio, $horaFim, $data_inicio,$data_fim,$consultorio_id, $diaSemanaArray){


        $data_inicio = $this->converterDatas_para_AAAA_MM_DD_com_Retorno($data_inicio);
        $data_fim = $this->converterDatas_para_AAAA_MM_DD_com_Retorno($data_fim);

        $model = new Agenda();

        $this->dadosConflituosos = $model->find()
        ->select(['diaSemana','horaInicio as Hora','DATE_FORMAT(data_inicio,"%d/%m/%Y") as Data'])
        ->where(['Consultorio_id' => $consultorio_id])
        ->andWhere(['>=', 'horaInicio', $horaInicio])
        ->andWhere(['<=', 'horaFim', $horaFim])
        ->andWhere(['>=', 'data_inicio', $data_inicio])
        ->andWhere(['<=', 'data_fim', $data_fim])
        ->andWhere('diaSemana IN ('. implode(',',$diaSemanaArray).')')
        ->andWhere('status = 1 OR status = 0')
        ->asArray()
        ->all();

        return $this->dadosConflituosos; //retorna toda linha do BD que 

    }



}
