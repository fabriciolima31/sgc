<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Usuarios".
 *
 * @property integer $id
 * @property string $cpf
 * @property string $password
 * @property string $nome
 * @property string $tipo
 * @property integer $Turma_id
 * @property string $auth_key
 *
 * @property Agenda[] $agendas
 * @property ProfessorTurma[] $professorTurmas
 * @property Turma[] $turmas
 * @property Sessao[] $sessaos
 * @property Turma $turma
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpf', 'password', 'nome', 'tipo'], 'required'],
            [['Turma_id'], 'integer'],
            [['cpf'], 'string', 'max' => 14],
            [['password'], 'string', 'max' => 40],
            [['nome'], 'string', 'max' => 200],
            [['tipo'], 'string', 'max' => 1],
            [['auth_key'], 'string', 'max' => 255],
            [['cpf'], 'unique'],
            [['Turma_id'], 'exist', 'skipOnError' => true, 'targetClass' => Turma::className(), 'targetAttribute' => ['Turma_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cpf' => 'Cpf',
            'password' => 'Password',
            'nome' => 'Nome',
            'tipo' => 'Tipo',
            'Turma_id' => 'Turma ID',
            'auth_key' => 'Auth Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgendas()
    {
        return $this->hasMany(Agenda::className(), ['Usuários_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessorTurmas()
    {
        return $this->hasMany(ProfessorTurma::className(), ['Usuários_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurmas()
    {
        return $this->hasMany(Turma::className(), ['id' => 'Turma_id'])->viaTable('Professor_Turma', ['Usuários_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSessaos()
    {
        return $this->hasMany(Sessao::className(), ['Usuários_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurma()
    {
        return $this->hasOne(Turma::className(), ['id' => 'Turma_id']);
    }
}
