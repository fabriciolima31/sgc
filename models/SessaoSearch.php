<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sessao;

/**
 * SessaoSearch represents the model behind the search form about `app\models\Sessao`.
 */
class SessaoSearch extends Sessao
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Paciente_id', 'Usuarios_id', 'Consultorio_id'], 'integer'],
            [['data', 'horario'], 'safe'],
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
        $query = Sessao::find()->where(['Usuarios_id' => Yii::$app->user->id, 'Paciente_id' => $params['Paciente_id']]);

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
            'Paciente_id' => $this->Paciente_id,
            'Usuarios_id' => $this->Usuarios_id,
            'Consultorio_id' => $this->Consultorio_id,
            'data' => $this->data,
        ]);

        $query->andFilterWhere(['like', 'horario', $this->horario]);

        return $dataProvider;
    }
    
    public function searchPaciente($params)
    {
        $query = UsuarioPaciente::find()->where(['Usuario_id' => Yii::$app->user->id, 'status' => '1']);

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
            'Paciente_id' => $this->Paciente_id,
            //'Usuarios_id' => $this->Usuarios_id,
            //'Consultorio_id' => $this->Consultorio_id,
        ]);

        return $dataProvider;
    }
}
