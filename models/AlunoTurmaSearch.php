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
    public function searchTurmas($params)
    {
        $query = AlunoTurma::find()->select('Turma_id')->groupBy('Turma_id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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

        return $dataProvider;
    }
    
    public function searchAlunos($params)
    {
        $query = AlunoTurma::find()->where(['Turma_id' => $params['Turma_id']]);
        $query->joinWith('usuario', 'Usuarios.id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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

        return $dataProvider;
    }
}
