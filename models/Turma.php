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
 * @property string $data_inicio
 * @property string $data_fim
 * @property integer $Disciplina_id
 *
 * @property Disciplina $disciplina
 * @property UsuarioTurma[] $usuarioTurmas
 * @property Usuarios[] $usuarios
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
            [['codigo', 'ano', 'semestre', 'data_inicio', 'data_fim', 'Disciplina_id'], 'required'],
            [['data_inicio', 'data_fim'], 'safe'],
            [['Disciplina_id'], 'integer'],
            [['codigo', 'semestre'], 'string', 'max' => 10],
            [['ano'], 'string', 'max' => 4],
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
            'codigo' => 'Codigo',
            'ano' => 'Ano',
            'semestre' => 'Semestre',
            'data_inicio' => 'Data Inicio',
            'data_fim' => 'Data Fim',
            'Disciplina_id' => 'Disciplina ID',
        ];
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
    public function getUsuarioTurmas()
    {
        return $this->hasMany(UsuarioTurma::className(), ['Turma_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['id' => 'Usuarios_id'])->viaTable('Usuario_Turma', ['Turma_id' => 'id']);
    }
}
