<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Relatorio;


class RelatorioSearch extends Relatorio
{

    public $quantidade_atendimentos;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id'], 'integer'],
            //[['cpf', 'password', 'nome', 'tipo', 'email'], 'safe'],
            //[['quantidade_atendimentos', 'nome'], 'safe'],
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

    public function searchDisciplina($params)
    {
            $id_usuario_logado = Yii::$app->user->identity->id;

            if(Yii::$app->user->identity->tipo == "4"){
            $query = Disciplina::find()
            ->alias("D")
            ->select("D.nome , T.codigo as codigo_turma, T.data_inicio, T.data_fim, T.id")
            ->leftJoin("Turma as T","T.Disciplina_id = D.id")
            ->leftJoin("Professor_Turma as PT","PT.Turma_id = T.id")
            ->where("D.status = 1");
            }
            else{

            $query = Disciplina::find()
            ->alias("D")
            ->select("D.nome , T.codigo as codigo_turma, T.data_inicio, T.data_fim, T.id")
            ->leftJoin("Turma as T","T.Disciplina_id = D.id")
            ->leftJoin("Professor_Turma as PT","PT.Turma_id = T.id")
            ->where(["PT.Usuarios_id" => $id_usuario_logado])
            ->andWhere("D.status = 1");
        }   

            /*$query = $query->asArray()->all();

            for ($i=0; $i<count($query); $i++){
                print_r($query[$i]);
                echo "<br><br>";
            }
            die;
            */

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



    public function searchAlunos($params, $id_da_turma)
    {

            $query = User::find()
            ->alias("U")
            ->select("U.nome, COUNT(S.id) as quantidade_atendimentos")
            ->leftJoin("Aluno_Turma as AT","AT.Usuarios_id = U.id")
            ->leftJoin("Sessao as S","S.Usuarios_id = U.id")
            ->where(["AT.Turma_id" => $id_da_turma])
            ->andWhere("U.tipo = 3")
            ->andWhere(["S.status" => "OS" ])
            ->groupBy("U.nome")
            ->having("quantidade_atendimentos > 0")
            ;

            $query2 = User::find()
            ->alias("U")
            ->select("U.nome, COUNT(S.id) as quantidade_atendimentos")
            ->leftJoin("Aluno_Turma as AT","AT.Usuarios_id = U.id")
            ->leftJoin("Sessao as S","S.Usuarios_id = U.id")
            ->where(["AT.Turma_id" => $id_da_turma])
            ->andWhere("U.tipo = 3")
            ->groupBy("U.nome")
            ->having("quantidade_atendimentos = 0")
            ;            

            $query->union($query2,false);

/*
            $query = $query->asArray()->all();

            for ($i=0; $i<count($query); $i++){
                print_r($query[$i]);
                echo "<br><br>";
            }
            die;
*/
            

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
