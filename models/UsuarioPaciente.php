<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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

    public function gerarListaDeTerapeutas(){

        $terapeutas = ArrayHelper::map(User::find()->select('Usuarios.id, Usuarios.nome')->leftJoin('Aluno_Turma', 'Usuarios_id = Usuarios.id')
                ->leftJoin('Turma', 'Turma_id = Turma.id')->where('data_fim > CURDATE()')->orWhere(['Usuarios.tipo' => '2'])->orderBy('Usuarios.nome')->all(), 'id', 'nome');

        return $terapeutas;


    }

    public function listarHistoricoTerapeutasDoPaciente($id){
      $terapeutas_anteriores =  UsuarioPaciente::find()
                                ->select("Usuario_Paciente.*, Usuarios.nome as nome_do_terapeuta")
                                ->innerJoin("Usuarios","Usuario_Paciente.Usuario_id = Usuarios.id")
                                ->where(["Paciente_id" => $id])
                                ->andWhere(["Usuario_Paciente.status" => "0"])
                                ->asArray()
                                ->all();

      return $terapeutas_anteriores;
    }
}
