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
            [['diaSemana','Consultorio_id', 'Usuarios_id'], 'integer'],
            [['horaInicio', 'horaFim', 'data_inicio', 'data_fim'], 'safe'],
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


    /*Funções para validação de atributos*/
    public function validateDateIni($attribute, $params){
        if (!$this->hasErrors()) {

            $date1= $this->data_inicio;
            $date2= date('d-m-Y');

        if (strtotime($date1) < strtotime($date2)) {
                $this->addError($attribute, 'Informe uma data igual ou posterior a '.date('d-m-Y'));
            }
        }

    }
    public function validateDateFim($attribute, $params){
        if (!$this->hasErrors()) {

            $date1= $this->data_inicio;
            $date2= $this->data_fim;

            if (strtotime($date2) < strtotime($date1)) {
                $this->addError($attribute, 'Informe uma data igual ou posterior a '.date("d-m-Y", strtotime($this->data_inicio)));
            }
        }
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
