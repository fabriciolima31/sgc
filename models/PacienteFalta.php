<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Paciente_falta".
 *
 * @property int $id
 * @property int $Paciente_id
 * @property int $FaltaJustificada
 * @property int $FaltaNaoJustificada
 * @property string $status
 */
class PacienteFalta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Paciente_falta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Paciente_id'], 'required'],
            [['Paciente_id', 'FaltaJustificada', 'FaltaNaoJustificada'], 'integer'],
            [['status'], 'string', 'max' => 1],
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
            'FaltaJustificada' => 'Falta Justificada',
            'FaltaNaoJustificada' => 'Falta Nao Justificada',
            'status' => 'Status',
        ];
    }
}
