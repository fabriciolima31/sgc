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
            [['diaSemana', 'horaInicio', 'horaFim', 'status', 'data_inicio', 'data_fim', 'nome_de_quem_agenda','nome_do_consultorio'], 'safe'],
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
        $query = Agenda::find()
        ->select("Agenda.*, U.nome as nome_de_quem_agenda, C.nome as nome_do_consultorio" )
        ->innerJoin("Usuarios as U", "U.id = Agenda.Usuarios_id")
        ->innerJoin("Consultorio as C", "C.id = Agenda.Consultorio_id")
        ->where(['Agenda.status' => '1']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

     $dataProvider->sort->attributes['nome_de_quem_agenda'] = [
        'asc' => ['nome_de_quem_agenda' => SORT_ASC],
        'desc' => ['nome_de_quem_agenda' => SORT_DESC],
        ];

    $dataProvider->sort->attributes['nome_do_consultorio'] = [
        'asc' => ['nome_do_consultorio' => SORT_ASC],
        'desc' => ['nome_do_consultorio' => SORT_DESC],
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
            'Consultorio_id' => $this->Consultorio_id,
            'Usuarios_id' => $this->Usuarios_id,
            'horaInicio' => $this->horaInicio,
            'horaFim' => $this->horaFim,
            'data_inicio' => $this->data_inicio,
            'data_fim' => $this->data_fim,
        ]);

        if($this->data_inicio != ""){
            $this->data_inicio = $model->converterDatas_para_DD_MM_AAAA_com_Retorno($this->data_inicio);
        }

        $query->andFilterWhere(['like', 'diaSemana', $this->diaSemana])
            ->andFilterWhere(['like', 'U.nome', $this->nome_de_quem_agenda])
            ->andFilterWhere(['like','C.nome',$this->nome_do_consultorio])
            ->andFilterWhere(['like', 'status', $this->status]);

        

        return $dataProvider;
    }
    
    public function searchAllModels($params){
         
         $reservas = Agenda::find()
        ->select("Agenda.*, U.nome as nome_de_quem_agenda, C.nome as nome_do_consultorio" )
        ->innerJoin("Usuarios as U", "U.id = Agenda.Usuarios_id")
        ->innerJoin("Consultorio as C", "C.id = Agenda.Consultorio_id")
        ->where(['Agenda.status' => '1', 'Consultorio_id' => $params['idConsultorio']]);
        
        return $reservas;
    }
}
