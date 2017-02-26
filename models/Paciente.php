<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Paciente".
 *
 * @property integer $id
 * @property string $nome
 * @property string $status
 * @property integer $Consultorio_id
 * @property string $horario
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
            [['Consultorio_id'], 'required'],
            [['Consultorio_id'], 'integer'],
            [['data_nascimento'], 'safe'],
            [['moradia', 'local_encaminhamento', 'local_terapia', 'servico', 'observacao'], 'string'],
            [['nome', 'endereco'], 'string', 'max' => 200],
            [['status', 'sexo', 'turno_atendimento'], 'string', 'max' => 1],
            [['horario', 'telefone'], 'string', 'max' => 10],
            [['motivo_psicoterapia'], 'string', 'max' => 45],
            [['Consultorio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consultorio::className(), 'targetAttribute' => ['Consultorio_id' => 'id']],
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
            'Consultorio_id' => 'Consultorio ID',
            'horario' => 'Horario',
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
        ];
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
    public function getSessaos()
    {
        return $this->hasMany(Sessao::className(), ['Paciente_id' => 'id']);
    }
}
