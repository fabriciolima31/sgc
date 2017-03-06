<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Aluno_Turma".
 *
 * @property integer $Turma_id
 * @property integer $Usuarios_id
 *
 * @property Turma $turma
 * @property Usuarios $usuarios
 */
class AlunoTurma extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Aluno_Turma';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Turma_id', 'Usuarios_id'], 'required'],
            [['Turma_id', 'Usuarios_id'], 'integer'],
            [['Turma_id'], 'exist', 'skipOnError' => true, 'targetClass' => Turma::className(), 'targetAttribute' => ['Turma_id' => 'id']],
            [['Usuarios_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['Usuarios_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Turma_id' => 'Turma ID',
            'Usuarios_id' => 'Alunos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurma()
    {
        return $this->hasOne(Turma::className(), ['id' => 'Turma_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'Usuarios_id']);
    }
}
