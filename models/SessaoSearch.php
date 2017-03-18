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

    //public $nome_do_paciente;

    public function rules()
    {
        return [
            [['id', 'Paciente_id', 'Usuarios_id', 'Consultorio_id'], 'integer'],
            [['data','nome_do_paciente', 'hora_inicio_consulta','data_inicio_consulta'], 'safe'],
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

        //$query->andFilterWhere(['like', 'horario', $this->horario]);

        return $dataProvider;
    }
    
        /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchSessoesEE($params)
    {
        $query = Sessao::find()
        ->select("Sessao.*, P.nome as nome_do_paciente, A.horaInicio as hora_inicio_consulta, A.data_inicio as data_inicio_consulta")
        ->innerJoin("Paciente as P","P.id = Sessao.Paciente_id")
        ->innerJoin("Agenda as A","A.id = Sessao.Agenda_id")
        ->where(['Sessao.Usuarios_id' => Yii::$app->user->id, 'Sessao.status' => 'EE']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 5 ],
        ]);

        $dataProvider->sort->attributes['nome_do_paciente'] = [
            'asc' => ['nome_do_paciente' => SORT_ASC],
            'desc' => ['nome_do_paciente' => SORT_DESC],

        ];
        $dataProvider->sort->attributes['hora_inicio_consulta'] = [
            'asc' => ['hora_inicio_consulta' => SORT_ASC],
            'desc' => ['hora_inicio_consulta' => SORT_DESC],

        ];
        $dataProvider->sort->attributes['data_inicio_consulta'] = [
            'asc' => ['data_inicio_consulta' => SORT_ASC],
            'desc' => ['data_inicio_consulta' => SORT_DESC],

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
            'Consultorio_id' => $this->Consultorio_id,
            'data' => $this->data,
        ]);

        $model = new Agenda();

        if($this->data_inicio_consulta !=  ""){
            $this->data_inicio_consulta = $model->converterDatas_para_AAAA_MM_DD_com_Retorno($this->data_inicio_consulta);
        }

        $query->andFilterWhere(['like', 'P.nome', $this->nome_do_paciente])
              ->andFilterWhere(['like', 'A.horaInicio', $this->hora_inicio_consulta])
              ->andFilterWhere(['like', 'A.data_inicio', $this->data_inicio_consulta]);

        if($this->data_inicio_consulta !=  ""){
            $this->data_inicio_consulta = $model->converterDatas_para_DD_MM_AAAA_com_Retorno($this->data_inicio_consulta);
        }

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
