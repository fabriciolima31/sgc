<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Consultorio".
 *
 * @property integer $id
 * @property string $nome
 *
 * @property Agenda[] $agendas
 * @property Paciente[] $pacientes
 * @property Sessao[] $sessaos
 */
class Consultorio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Consultorio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['nome'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgendas()
    {
        return $this->hasMany(Agenda::className(), ['Consultorio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
        return $this->hasMany(Paciente::className(), ['Consultorio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSessaos()
    {
        return $this->hasMany(Sessao::className(), ['Consultório_id' => 'id']);
    }
}
