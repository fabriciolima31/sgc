<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Sessao".
 *
 * @property integer $id
 * @property integer $Paciente_id
 * @property integer $Usuarios_id
 * @property integer $Consultorio_id
 * @property string $data
 *
 * @property Consultorio $consultorio
 * @property Paciente $paciente
 * @property Usuarios $usuarios
 */
class Sessao extends \yii\db\ActiveRecord
{

    public $data;
    public $pacienteFalta;
    public $statusDescArray = ['EE' => 'Em Espera', 'NO' => 'Não Ocorrida', 'OS' => 'Ocorrida', 'FE' => 'Fechada'];
    public $statusNODescArray = ['PCJ' => 'Paciente Ausente COM justificativa', 'PSJ' => 'Paciente Ausente SEM justificativa', 'TA' => 'Terapeuta Ausente', 'OI' => 'Outro Impedimento'];

    public $contagem_pacientes;
    public $nome_do_paciente;
    public $data_inicio_consulta;
    public $hora_inicio_consulta;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Sessao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Paciente_id', 'Usuarios_id', 'Consultorio_id' ,'data'], 'required'],
            [['Paciente_id', 'Usuarios_id', 'Consultorio_id'], 'integer'],
            [[ 'data','status'], 'safe'],
            [['observacao'], 'required','on'=> 'altera-status', 'when' => function($model) {
                return $model->status == 'OI';
            }, 'whenClient' => "function (attribute, value) {
                return false;
            }"],
            [['pacienteFalta'], 'string'],
            [['status'], 'required','on'=> 'altera-status'],
            [['observacao'], 'string', 'max' => 500],
            [['Consultorio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consultorio::className(), 'targetAttribute' => ['Consultorio_id' => 'id']],
            [['Paciente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['Paciente_id' => 'id']],
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
            'Paciente_id' => 'Paciente ID',
            'Usuarios_id' => 'Usuarios ID',
            'Consultorio_id' => 'Consultorio',
            'data' => 'Data e Horário',
        ];
    }
    
    public function beforeSave($insert) {
        $this->converterDatas_para_AAAA_MM_DD();
        return true;
    }
    
    public function afterFind() {
        $this->converterDatas_para_DD_MM_AAAA();
        return true;
    }
    
    public function getStatusDesc(){
        return $this->statusDescArray[$this->status];
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
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'Paciente_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'Usuarios_id']);
    }
    
        /* Conversão de Data*/
    public function converterDatas_para_AAAA_MM_DD() {

        $ano = substr($this->data,6,4); //pega os 4 ultimos caracteres, a contar do índice 4
        $mes = substr($this->data,3,2); //pega os 2 caracteres, a contar do índice 2
        $dia = substr($this->data,0,2); //pega os 2 caracteres, a contar do índice 0
        $this->data = $ano."-".$mes."-".$dia;
        
    }

    /*Conversão de Data*/
    public function converterDatas_para_DD_MM_AAAA() {

        $ano = substr($this->data,0,4); //pega os 4 ultimos caracteres, a contar do índice 4
        $mes = substr($this->data,5,2); //pega os 2 caracteres, a contar do índice 2
        $dia = substr($this->data,8,2); //pega os 2 caracteres, a contar do índice 0
        $this->data = $dia."-".$mes."-".$ano;
    }

    public function verificaSeHaAgendamentoVago (){

        if(Yii::$app->user->isGuest) {
            return $this->goHome();
           }
        
       $user_logado = Yii::$app->user->identity->id;

        $countPosts = Agenda::find()
                ->select("D.nome as nome_da_disciplina, T.*, Agenda.*")
                ->innerJoin("Turma as T","T.id = Agenda.Turma_id")
                ->innerJoin("Disciplina as D","D.id = T.Disciplina_id")
                ->where(["Agenda.Usuarios_id" => $user_logado])
                ->andWhere(['Agenda.status' => 1])
                ->andWhere("Agenda.data_inicio > CURDATE()")
                ->orWhere("Agenda.data_inicio = CURDATE() AND horaInicio >= CURTIME()")
                ->count();

        return $countPosts;


    }

}
