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
 * @property string $horario
 *
 * @property Consultorio $consultorio
 * @property Paciente $paciente
 * @property Usuarios $usuarios
 */
class Sessao extends \yii\db\ActiveRecord
{
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
            [['Paciente_id', 'Usuarios_id', 'Consultorio_id', 'data', 'horario'], 'required'],
            [['Paciente_id', 'Usuarios_id', 'Consultorio_id'], 'integer'],
            [['data'], 'safe'],
            [['horario'], 'string', 'max' => 45],
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
            'Consultorio_id' => 'Consultorio ID',
            'data' => 'Data',
            'horario' => 'Horario',
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
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'Paciente_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(User::className(), ['id' => 'Usuarios_id']);
    }
}
