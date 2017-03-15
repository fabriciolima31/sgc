<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Disciplina".
 *
 * @property integer $id
 * @property string $nome
 *
 * @property Turma[] $turmas
 */
class Disciplina extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Disciplina';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 45],
            [['status'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurmas()
    {
        return $this->hasMany(Turma::className(), ['Disciplina_id' => 'id']);
    }
    
    public function getStatusDesc(){
        return $this->status == 1 ? "Habilitado" : "Desabilitado";
    }
}