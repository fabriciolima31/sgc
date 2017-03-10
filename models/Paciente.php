<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "Paciente".
 *
 * @property integer $id
 * @property string $nome
 * @property string $status
 * @property string $sexo
 * @property string $data_nascimento
 * @property string $telefone
 * @property string $endereco
 * @property string $moradia
 * @property string $turno_atendimento
 * @property string $local_encaminhamento
 * @property string $local_terapia
 * @property string $motivo_psicoterapia
 * @property string $servico
 * @property string $observacao
 *
 * @property Consultorio $consultorio
 * @property Sessao[] $sessaos
 */
class Paciente extends \yii\db\ActiveRecord
{
    //Ambos os Arrays foram copiados para indexadministrador
    public $statusDescs = ["EN"=> "Encaminhado", "LE" => "Lista de Espera", 'EC' => "Entrar em Contato", 
        "EA" => "Em Atendimento", "DE" => "Desistente", "AB" => "Abandono", "AL" => "Alta"];
    
    public $prioridadeArray = ['A' => 'Alta', 'M' => 'Média', 'N' => 'Normal', 'B' => 'Baixa'];
    
    public $turno_atendimentoArray = ['M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite'];
        
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Paciente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data_nascimento', 'moradia', 
                'servico', 'nome', 'endereco', 'sexo', 'turno_atendimento',
                'motivo_psicoterapia', 'telefone'], 'required'],
            [['data_nascimento', 'data_inscricao'], 'safe'],
            [['moradia', 'local_encaminhamento', 'local_terapia', 'servico', 'observacao'], 'string'],
            [['nome', 'endereco'], 'string', 'max' => 200],
            [['status', 'sexo', 'turno_atendimento'], 'string', 'max' => 21],
            [['telefone'], 'string', 'max' => 10],
            [['motivo_psicoterapia'], 'string', 'max' => 45],
            [['prioridade', 'complexidade'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'status' => 'Status',
            'statusDesc' => 'Status',
            'sexo' => 'Sexo',
            'data_nascimento' => 'Data Nascimento',
            'telefone' => 'Telefone',
            'endereco' => 'Endereco',
            'moradia' => 'Moradia',
            'turno_atendimento' => 'Turno Atendimento',
            'local_encaminhamento' => 'Local Encaminhamento',
            'local_terapia' => 'Local Terapia',
            'motivo_psicoterapia' => 'Motivo Psicoterapia',
            'servico' => 'Servico',
            'observacao' => 'Observacao',
            'data_inscrição' => 'Data de Inscrição',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSessoes()
    {
        return $this->hasMany(Sessao::className(), ['Paciente_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario_Paciente()
    {
        return $this->hasMany(UsuarioPaciente::className(), ['Paciente_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacienteFalta()
    {
        return $this->hasMany(Paciente_Falta::className(), ['Paciente_id' => 'id']);
    }
    
    
    /*
     * Descricão dos status
     */
    public function getStatusDesc(){
        return $this->statusDescs[$this->status];
    }
    
    /*
     * Descricao da prioridade e complexidade
     */
    public function getPrioridadeDesc(){
        return $this->prioridade == null ? "-" : $this->prioridadeArray[$this->prioridade];
    }
    
    /*
     * Descricao do turno de Atendimento
     */
    public function getTurnoAtendimentoDesc(){
        return $this->turno_atendimentoArray[$this->turno_atendimento];
    }


    /*
     * Descricão dos status
     */
    public function getStatus1($status){
        if(isset($this->statusDescs[$status])){
            return $this->statusDescs[$status];
        }
        
        return "Todos";
    }
    
    public function setStatus($action){
        if ($action == 'Alocar') {
            $this->status = 'EC';
        }else if($action == 'Sessao'){
            $this->status = 'EA';
        }

        $this->save();
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->status = "LE";
            $this->data_inscricao = date('d-m-y H:i:s', time());
        }
        
        $this->converterDatas_para_AAAA_MM_DD();
        
        return true;
    }
    
    public function afterFind() {
        $this->converterDatas_para_DD_MM_AAAA();
        
        if($this->status == 'EA'){
            $pacienteFalta = PacienteFalta::find()->where(['Paciente_id' => $this->id])->one();
            if($pacienteFalta->FaltaNaoJustificada >= 3 || ($pacienteFalta->FaltaJustificada + $pacienteFalta->FaltaNaoJustificada) >= 5){
                $this->status = 'AB';
                
                $usuarioPacientes = Sessao::findAll(['Paciente_id' => $this->id, 'status' => 'EE']);
        
                foreach ($usuarioPacientes as $usuarioPaciente) {
                    $usuarioPaciente->status = 'FE';
                    $usuarioPaciente->save();
                }
                $this->save();
            }
        }
        return true;
    }
    
    public function converterDatas_para_AAAA_MM_DD() {

        $ano = substr($this->data_nascimento,6,4); //pega os 4 ultimos caracteres, a contar do índice 4
        $mes = substr($this->data_nascimento,3,2); //pega os 2 caracteres, a contar do índice 2
        $dia = substr($this->data_nascimento,0,2); //pega os 2 caracteres, a contar do índice 0
        $this->data_nascimento = $ano."-".$mes."-".$dia;
    }

    public function converterDatas_para_DD_MM_AAAA() {

        $ano = substr($this->data_nascimento,0,4); //pega os 4 ultimos caracteres, a contar do índice 4
        $mes = substr($this->data_nascimento,5,2); //pega os 2 caracteres, a contar do índice 2
        $dia = substr($this->data_nascimento,8,2); //pega os 2 caracteres, a contar do índice 0
        $this->data_nascimento = $dia."-".$mes."-".$ano;
    }
    
    public function statusFinal(){
        if (!($this->status == 'DE' || $this->status == 'AB' || $this->status == 'AL')) {
            return true;
        }
        
        return false;
    }
}
