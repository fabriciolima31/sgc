<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Agenda".
 *
 * @property integer $Consultorio_id
 * @property integer $Usuarios_id
 * @property string $diaSemana
 * @property string $horaInicio
 * @property string $horaFim
 * @property string $status
 *
 * @property Consultorio $consultorio
 * @property Usuarios $usuarios
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
            [['Consultorio_id', 'Usuarios_id', 'diaSemana', 'horaInicio', 'status'], 'required'],
            [['Consultorio_id', 'Usuarios_id'], 'integer'],
            [['horaInicio', 'horaFim'], 'safe'],
            [['diaSemana'], 'string', 'max' => 7],
            [['status'], 'string', 'max' => 1],
            [['Consultorio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consultorio::className(), 'targetAttribute' => ['Consultorio_id' => 'id']],
            [['Usuarios_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['Usuarios_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Consultorio_id' => 'Consultorio ID',
            'Usuarios_id' => 'Usuarios ID',
            'diaSemana' => 'Dia Semana',
            'horaInicio' => 'Hora Inicio',
            'horaFim' => 'Hora Fim',
            'status' => 'Status',
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
}
