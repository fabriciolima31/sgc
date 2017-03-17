<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Turma;

/**
 * TurmaSearch represents the model behind the search form about `app\models\Turma`.
 */
class TurmaSearch extends Turma
{

    public $nome_do_usuario;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Disciplina_id'], 'integer'],
            [['codigo', 'ano', 'semestre', 'data_inicio', 'data_fim', 'Professor_id'], 'safe'],
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
        $query = Turma::find()->select("Turma.* , PT.*, U.nome as nome_do_usuario, U.id as Professor_id")
        ->innerJoin("Professor_Turma as PT","PT.Turma_id = Turma.id")
        ->innerJoin("Usuarios as U","U.id = PT.Usuarios_id");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

     $dataProvider->sort->attributes['Professor_id'] = [
        'asc' => ['nome_do_usuario' => SORT_ASC],
        'desc' => ['nome_do_usuario' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'data_inicio' => $this->data_inicio,
            'data_fim' => $this->data_fim,
            'Disciplina_id' => $this->Disciplina_id,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'ano', $this->ano])
            ->andFilterWhere(['like', 'U.id', $this->Professor_id])
            ->andFilterWhere(['like', 'semestre', $this->semestre]);

        return $dataProvider;
    }
    
        public function searchTurmasAtivas($params)
    {
        $query = Turma::find()->where("data_fim >= CURDATE()");

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
            'id' => $this->id,
            'data_inicio' => $this->data_inicio,
            'data_fim' => $this->data_fim,
            'Disciplina_id' => $this->Disciplina_id,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'ano', $this->ano])
            ->andFilterWhere(['like', 'semestre', $this->semestre]);

        return $dataProvider;
    }
}
