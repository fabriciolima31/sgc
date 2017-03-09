<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Usuario_Paciente".
 *
 * @property string $Paciente_id
 * @property integer $Usuarios_id
 * @property string $status
 *
 * @property Paciente $paciente
 * @property Usuarios $usuarios
 */
class UsuarioPaciente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Usuario_Paciente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Paciente_id', 'Usuario_id', 'status'], 'required'],
            [['Paciente_id', 'Usuario_id'], 'integer'],
            [['observacao'], 'required','on'=> 'encaminhar'],
            [['status'], 'string', 'max' => 1],
            [['observacao'], 'string', 'max' => 500],
            [['Paciente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['Paciente_id' => 'id']],
            [['Usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['Usuario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Paciente_id' => 'Paciente',
            'Usuario_id' => 'Terapeuta',
            'status' => 'Status',
        ];
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
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'Usuario_id']);
    }
}
