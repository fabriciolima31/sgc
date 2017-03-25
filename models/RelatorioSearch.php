<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Relatorio;


class RelatorioSearch extends Relatorio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id'], 'integer'],
            //[['cpf', 'password', 'nome', 'tipo', 'email'], 'safe'],
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

            $query = User::find()
            ->alias("U1")
            ->select("U1.* , AT.*")
            ->innerJoin("Aluno_Turma as AT","AT.Usuarios_id = U1.id")
            ->innerJoin("Turma as T","T.id = AT.Turma_id")
            //->innerJoin("Professor_Turma as PT", "PT.Usuarios_id = U2.id")
            ->where(['U1.tipo' => 3]);


        //1- tem de pegar o usuário LOGADO.
        //2- tem de VERIFICAR SE O PERFIL É DE PROFESSOR OU ALUNO !
        //3- tem de pegar as disciplinas do professor
        //4- tem de pegar os alunos desse professor




        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}
