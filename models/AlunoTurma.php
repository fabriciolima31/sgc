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

    public $nome_da_disciplina;
    public $codigo_da_turma;
    public $id_da_turma;
    public $nome_do_professor;



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
            'Turma_id' => 'Turma',
            'Usuarios_id' => 'Aluno',
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
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'Usuarios_id']);
    }

    public function checaAlocacao($Turma_id, $Usuarios_id)
    {
        if (($model = AlunoTurma::findOne(['Turma_id' => $Turma_id, 'Usuarios_id' => $Usuarios_id])) !== null) {
            $this->addError("Usuarios_id", "Este aluno já  está alocado nessa disciplina");
            return $model;

        } else {
            return null;
        }
    }

    public function verificaSeAlunoJaEstaVinculadoTurma(){

        $disciplina = Turma::find()
        ->select("Disciplina.id as id_da_disciplina, Turma.ano, Turma.semestre")
        ->innerJoin("Disciplina","Disciplina.id = Turma.Disciplina_id")
        ->where(["Turma.id" => $this->Turma_id])->one();


        $usuarioJaEstaNessaDisciplina = AlunoTurma::find()
        ->select("Disciplina.id")
        ->innerJoin("Turma","Aluno_Turma.Turma_id = Turma.id")
        ->innerJoin("Disciplina","Disciplina.id = Turma.Disciplina_id")
        ->where(['Turma.ano' => $disciplina->ano])
        ->andWhere(['Turma.semestre' => $disciplina->semestre])
        ->andWhere(["Disciplina.id" => $disciplina->id_da_disciplina])
        ->andWhere(["Aluno_Turma.Usuarios_id" => $this->Usuarios_id])
        ->count();

        if($usuarioJaEstaNessaDisciplina > 0){
            $this->addError("Usuarios_id", "Este aluno já está alocado nessa disciplina, porém em outra turma");
            return 1;
        }
        return 0;

    }    

}
