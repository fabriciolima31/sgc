<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UsuarioPaciente;

/**
 * UsuarioPacienteSearch represents the model behind the search form about `app\models\UsuarioPaciente`.
 */
class UsuarioPacienteSearch extends UsuarioPaciente
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Paciente_id', 'Usuario_id'], 'integer'],
            [['status', 'nome_do_paciente', 'status_do_paciente', 'nome_terapeuta' ], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UsuarioPaciente::find()
        ->select("Usuario_Paciente.* , P.nome as nome_do_paciente, 
            P.status as status_do_paciente, U.nome as nome_terapeuta")
        ->innerJoin("Paciente as P","P.id = Usuario_Paciente.Paciente_id")
        ->innerJoin("Usuarios as U","U.id = Usuario_Paciente.Usuario_id")
        ->where(['Usuario_Paciente.status' => '1']);


       // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

     $dataProvider->sort->attributes['nome_do_paciente'] = [
        'asc' => ['nome_do_paciente' => SORT_ASC],
        'desc' => ['nome_do_paciente' => SORT_DESC],
        ];

     $dataProvider->sort->attributes['nome_terapeuta'] = [
        'asc' => ['nome_terapeuta' => SORT_ASC],
        'desc' => ['nome_terapeuta' => SORT_DESC],
        ];

     $dataProvider->sort->attributes['status_do_paciente'] = [
        'asc' => ['status_do_paciente' => SORT_ASC],
        'desc' => ['status_do_paciente' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'Paciente_id' => $this->Paciente_id,
            'Usuario_id' => $this->Usuario_id,
            'P.status' => $this->status,
        ]);

       
        $query->andFilterWhere(['like', 'P.nome', $this->nome_do_paciente])
            ->andFilterWhere(['like', 'U.nome', $this->nome_terapeuta]);

        

        return $dataProvider;
    }
}
