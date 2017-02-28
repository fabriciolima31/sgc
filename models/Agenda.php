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
            [['Consultorio_id', 'Usuarios_id', 'diaSemana', 'horaInicio', 'horaFim', 'status', 'data_inicio', 'data_fim'], 'required'],
            [['Consultorio_id', 'Usuarios_id'], 'integer'],
            [['horaInicio', 'horaFim', 'data_inicio', 'data_fim'], 'safe'],
            [['diaSemana'], 'string', 'max' => 20],
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
            'Consultorio_id' => 'Consultorio ID',
            'Usuarios_id' => 'Usuarios ID',
            'diaSemana' => 'Dia Semana',
            'horaInicio' => 'Hora Inicio',
            'horaFim' => 'Hora Fim',
            'status' => 'Status',
            'data_inicio' => 'Data Inicio',
            'data_fim' => 'Data Fim',
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
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'Usuarios_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
        return $this->hasMany(Paciente::className(), ['Agenda_id' => 'id']);
    }
}
