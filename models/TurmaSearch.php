<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Turma;
use app\models\Agenda;

/**
 * TurmaSearch represents the model behind the search form about `app\models\Turma`.
 */
class TurmaSearch extends Turma
{

   /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Disciplina_id'], 'integer'],
            [['codigo', 'ano', 'semestre', 'data_inicio', 'data_fim', 'nome_do_usuario', 'nome_da_disciplina'], 'safe'],
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
        $query = Turma::find()->select("Turma.* , PT.*, Usuarios.nome as nome_do_usuario, Usuarios.id as Professor_id")
        ->innerJoin("Professor_Turma as PT","PT.Turma_id = Turma.id")
        ->innerJoin("Usuarios","Usuarios.id = PT.Usuarios_id");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

     $dataProvider->sort->attributes['nome_do_usuario'] = [
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
            ->andFilterWhere(['like', 'nome', $this->nome_do_usuario])
            ->andFilterWhere(['like', 'semestre', $this->semestre]);

            //esse segundo parámetro tem de ser um atributo DA TABELA, e não apenas do model!

        return $dataProvider;
    }
    
        public function searchTurmasAtivas($params)
    {
        $query = Turma::find()
        ->select("Turma.* , D.nome as nome_da_disciplina")
        ->innerJoin("Disciplina as D", "D.id = Turma.Disciplina_id")
        ->where("data_fim >= CURDATE()");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['nome_da_disciplina'] = [
        'asc' => ['nome_da_disciplina' => SORT_ASC],
        'desc' => ['nome_da_disciplina' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $model = new Agenda();

        if($this->data_inicio != ""){
            $this->data_inicio = $model->converterDatas_para_AAAA_MM_DD_com_Retorno($this->data_inicio);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'data_inicio' => $this->data_inicio,
            'data_fim' => $this->data_fim,
            'Disciplina_id' => $this->Disciplina_id,
        ]);


        if($this->data_inicio != ""){
            $this->data_inicio = $model->converterDatas_para_DD_MM_AAAA_com_Retorno($this->data_inicio);
        }

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'ano', $this->ano])
            ->andFilterWhere(['like', 'D.nome', $this->nome_da_disciplina])
            ->andFilterWhere(['like', 'semestre', $this->semestre]);

        return $dataProvider;
    }
}
