<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Agenda;

/**
 * AgendaSearch represents the model behind the search form about `app\models\Agenda`.
 */
class AgendaSearch extends Agenda
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Consultorio_id', 'Usuarios_id'], 'integer'],
            [['diaSemana', 'horaInicio', 'horaFim', 'status', 'data_inicio', 'data_fim'], 'safe'],
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
        //$query = Agenda::find()->where(['status' => '1'])->orderBy('data_inicio, horaInicio');
        $query = Agenda::find()->where(['status' => '1']);

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
            'Consultorio_id' => $this->Consultorio_id,
            'Usuarios_id' => $this->Usuarios_id,
            'horaInicio' => $this->horaInicio,
            'horaFim' => $this->horaFim,
            'data_inicio' => $this->data_inicio,
            'data_fim' => $this->data_fim,
        ]);

        $query->andFilterWhere(['like', 'diaSemana', $this->diaSemana])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
