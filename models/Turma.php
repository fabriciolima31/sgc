<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Turma".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $ano
 * @property string $semestre
 * @property string $data_inicio
 * @property string $data_fim
 * @property integer $Disciplina_id
 *
 * @property Disciplina $disciplina
 * @property UsuarioTurma[] $usuarioTurmas
 * @property Usuarios[] $usuarios
 */
class Turma extends \yii\db\ActiveRecord
{

    public $Professor_id;
    public $nome_do_usuario;
    public $nome_da_disciplina;
    public $id_da_disciplina;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Turma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'ano', 'semestre', 'data_inicio', 'data_fim', 'Disciplina_id', 'Professor_id'], 'required'],
            [['data_inicio', 'data_fim' , 'Professor_id'], 'safe'],
            [['Disciplina_id'], 'integer'],
            [['codigo', 'semestre'], 'string', 'max' => 10],
            [['ano'], 'string', 'max' => 4],
            [['Disciplina_id'], 'exist', 'skipOnError' => true, 'targetClass' => Disciplina::className(), 'targetAttribute' => ['Disciplina_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Código',
            'ano' => 'Ano',
            'semestre' => 'Semestre Letivo',
            'data_inicio' => 'Data Inicio',
            'data_fim' => 'Data Fim',
            'Disciplina_id' => 'Disciplina',
            'Professor_id' => "Professor(a)",
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplina()
    {
        return $this->hasOne(Disciplina::className(), ['id' => 'Disciplina_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessorTurmas()
    {
        return $this->hasMany(ProfessorTurma::className(), ['Turma_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(User::className(), ['id' => 'Usuarios_id'])->viaTable('Professor_Turma', ['Turma_id' => 'id']);
    }
    
        public function afterFind() {
        $this->converterDatas_para_DD_MM_AAAA();
        return true;
    }
    
    public function beforeSave($insert) {
        $this->converterDatas_para_AAAA_MM_DD();
        return true;
    }
    
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
}
