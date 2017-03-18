<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AlunoTurma;

/**
 * AlunoTurmaSearch represents the model behind the search form about `app\models\AlunoTurma`.
 */
class AlunoTurmaSearch extends AlunoTurma
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Turma_id', 'Usuarios_id'], 'integer'],
            [['nome_do_aluno'], 'safe'],
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

    public function searchAlunos($params,$params2)
    {
        $query = AlunoTurma::find()
        ->select("Aluno_Turma.*, U.nome as nome_do_aluno")
        ->innerJoin('Usuarios as U', 'U.id = Aluno_Turma.Usuarios_id')
        ->where(['Turma_id' => $params2]);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['nome_do_aluno'] = [
        'asc' => ['nome_do_aluno' => SORT_ASC],
        'desc' => ['nome_do_aluno' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'Turma_id' => $this->Turma_id,
            'Usuarios_id' => $this->Usuarios_id,
        ]);

        $query->andFilterWhere(['like', 'U.nome', $this->nome_do_aluno]);

        return $dataProvider;
    }
}
