<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['cpf', 'password', 'nome', 'tipo', 'email'], 'safe'],
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
    public function search($params,$params2)
    {

        if ($params2['perfil'] == 1) {
            $query = User::find()->where(['status' => 1, 'tipo' => 1]);
        } else if ($params2['perfil'] == 2) {
            $query = User::find()->where(['status' => 1, 'tipo' => 2]);
        } else if ($params2['perfil'] == 3) {
            $query = User::find()->where(['status' => 1, 'tipo' => 3]);
        } else if ($params2['perfil'] == 4) {
            $query = User::find()->where(['status' => 1, 'tipo' => 4]);
        } else {
            $query = User::find()->where(['status' => 1]);
        }

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
        ]);

        $query->andFilterWhere(['like', 'cpf', $this->cpf])
            ->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'tipo', $this->tipo]);

        return $dataProvider;
    }
}
