<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Paciente;

/**
 * PacienteSearch represents the model behind the search form about `app\models\Paciente`.
 */
class PacienteSearch extends Paciente
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Consultorio_id'], 'integer'],
            [['nome', 'status', 'horario', 'sexo', 'data_nascimento', 'telefone', 'endereco', 'moradia', 'turno_atendimento', 'local_encaminhamento', 'local_terapia', 'motivo_psicoterapia', 'servico', 'observacao', 'data_inscricao'], 'safe'],
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
        $query = Paciente::find()->where(['status' => 'LE']);

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
            'data_nascimento' => $this->data_nascimento,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'horario', $this->horario])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'telefone', $this->telefone])
            ->andFilterWhere(['like', 'endereco', $this->endereco])
            ->andFilterWhere(['like', 'moradia', $this->moradia])
            ->andFilterWhere(['like', 'turno_atendimento', $this->turno_atendimento])
            ->andFilterWhere(['like', 'local_encaminhamento', $this->local_encaminhamento])
            ->andFilterWhere(['like', 'local_terapia', $this->local_terapia])
            ->andFilterWhere(['like', 'motivo_psicoterapia', $this->motivo_psicoterapia])
            ->andFilterWhere(['like', 'servico', $this->servico])
            ->andFilterWhere(['like', 'observacao', $this->observacao]);

        return $dataProvider;
    }
}
