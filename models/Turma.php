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
 * @property integer $Disciplina_id
 *
 * @property ProfessorTurma[] $professorTurmas
 * @property Usuarios[] $usuarios
 * @property Disciplina $disciplina
 * @property Usuarios[] $usuarios0
 */
class Turma extends \yii\db\ActiveRecord
{
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
            [['Disciplina_id'], 'required'],
            [['Disciplina_id'], 'integer'],
            [['codigo', 'ano', 'semestre'], 'string', 'max' => 45],
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
            'semestre' => 'Semestre',
            'Disciplina_id' => 'Disciplina',
        ];
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
        return $this->hasMany(Usuarios::className(), ['id' => 'Usuarios_id'])->viaTable('Professor_Turma', ['Turma_id' => 'id']);
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
    public function getUsuarios0()
    {
        return $this->hasMany(Usuarios::className(), ['Turma_id' => 'id']);
    }
}
