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
        "EA" => "Em Atendimento", "DE" => "Desistente", "AB" => "Abandono", "AL" => "Alta", 
        "DV" => "Devolvido"];
    
    public $prioridadeArray = ['A' => 'Alta', 'M' => 'Média', 'N' => 'Normal', 'B' => 'Baixa'];

    public $complexidadeArray = ['A' => 'Alta', 'M' => 'Média', 'N' => 'Normal', 'B' => 'Baixa'];
    
    public $turno_atendimentoArray = ['M' => 'Manhã', 'T' => 'Tarde', 'N' => 'Noite'];

    public $nome_do_terapeuta;
        
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
            [['moradia', 'local_encaminhamento', 'local_terapia', 'servico'], 'string'],
            [['nome', 'endereco'], 'string', 'max' => 200],
            [['status', 'sexo', 'turno_atendimento'], 'string', 'max' => 21],
            [['telefone', 'telefone2'], 'string', 'max' => 10],
            [['motivo_psicoterapia'], 'string', 'max' => 120],
            [['observacao'], 'string',  'max' => 120],
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
            'data_nascimento' => 'Data de Nascimento',
            'telefone' => 'Telefone 1',
            'telefone2' => 'Telefone 2',
            'endereco' => 'Endereço',
            'moradia' => 'Com que mora?',
            'turno_atendimento' => 'Turno Atendimento',
            'local_encaminhamento' => 'De onde veio encaminhado?',
            'local_terapia' => 'Qual o local onde já realizou terapia?',
            'motivo_psicoterapia' => 'Motivo da Psicoterapia',
            'servico' => 'Como soube do serviço?',
            'observacao' => 'Observação',
            'data_inscrição' => 'Data da Inscrição',
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

    public function getComplexidadeDesc(){
        return $this->complexidade == null ? "-" : $this->complexidadeArray[$this->complexidade];
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
            $this->data_inscricao = date('Y-m-d', time());
        }
        
        $this->converterDatas_para_AAAA_MM_DD();
        
        return true;
    }
    
    public function afterFind() {
        $this->converterDatas_para_DD_MM_AAAA();
        
        if($this->status == 'EA'){
            $pacienteFalta = PacienteFalta::find()->where(['Paciente_id' => $this->id])->one();
            if($pacienteFalta->FaltaNaoJustificadaSeguida >= 3 || ($pacienteFalta->FaltaJustificada + $pacienteFalta->FaltaNaoJustificada) >= 5){
                $this->status = 'AB';
                $pacienteFalta->status = '0';
                $pacienteFalta->save(false);
                
                $this->fecharSessoes();
                
                $this->save();
            }
        }
        return true;
    }
    
    public function fecharSessoes(){
        $sessoesPacientes = Sessao::findAll(['Paciente_id' => $this->id, 'status' => 'EE']);
        
        foreach ($sessoesPacientes as $sessoesPaciente) {
            $agendaPaciente = Agenda::find()->where(['id' => $sessoesPaciente->Agenda_id])->one();
            $agendaPaciente->status = '1';
            $agendaPaciente->save(false);
            $sessoesPaciente->status = 'FE';
            $sessoesPaciente->save();
        }
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
