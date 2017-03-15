<?php

namespace app\controllers;

use Yii;
use app\models\Agenda;
use app\models\AlunoTurma;
use app\models\AgendaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AgendaController implements the CRUD actions for Agenda model.
 */
class AgendaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'delete','turmas'],
                        'allow' => true,
                        'roles' => ['@' ],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@' ],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->tipo == '4';
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Agenda models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgendaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Agenda model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Agenda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Agenda();

        if ($model->load(Yii::$app->request->post())) {
            
            $dadosConflituosos = $model->verificarConflitosNoInsert($model->horaInicio, $model->horaFim,$model->data_inicio, $model->data_fim, $model->Consultorio_id, $model->diaSemanaArray);

            $quantidade_dados_conflituosos = count($dadosConflituosos);

            echo $quantidade_dados_conflituosos;

            if($quantidade_dados_conflituosos > 0){

                return $this->render('create', [
                    'model' => $model,
                    'dadosConflituosos' => $dadosConflituosos,
                    'diaSemanaArray' => $model->diaSemanaArray
                ]);
            }
           
            if($model->validate()){

                $datetime1 = new \DateTime($model->data_inicio);
                $datetime2 = new \DateTime($model->data_fim);
                $interval = $datetime1->diff($datetime2);
                $diferencaDias =  abs($interval->format('%a'));
                $diferencaDias++;

                $auxDataInicio = $model->data_inicio;

                for($i=0; $i<$diferencaDias; $i++){

                    $hora_incrementada= date('H:i',strtotime($model->horaInicio));
                    $hora_limite = date('H:i',strtotime($model->horaFim));

                    $dataDoLoop = date('d-m-Y',date(strtotime("+".$i." days", strtotime($auxDataInicio))));

                    // 0 é domingo, 1 é segunda, 2 é terça, 3 é quarta, 4 é quinta, 5 é sexta, 6 é sábado
                    $diaDaSemana = date('w', strtotime($dataDoLoop));


                    $array_semanas = array([0 => "Domingo" , 1 => 'Segunda-Feira', 2 => 'Terça-Feira', 3 => 'Quarta-Feira', 4 => 'Quinta-Feira', 5 => 'Sexta-Feira', 6 => 'Sábado' ]);


                    if(in_array($diaDaSemana, $model->diaSemanaArray)) { 


                        while($hora_incrementada < $hora_limite){

                            $aux = $hora_incrementada;
                            $hora_incrementada =  date('H:i',strtotime($hora_incrementada) + 60*60);

                            $model->id = null;
                            $model->isNewRecord = true;
                            //$model->Usuarios_id = Yii::$app->user->id;
                            $model->status = '1';
                            $model->diaSemana = $diaDaSemana;
                            $model->data_inicio = $dataDoLoop;
                            $model->data_fim = $dataDoLoop;
                            $auxHoraInicio = $model->horaInicio;
                            $model->horaInicio = $aux;
                            $auxHoraFim = $model->horaFim;
                            $model->horaFim = $hora_incrementada;
                            $model->save();
                            $model->horaFim = $auxHoraFim;
                            $model->horaInicio = $auxHoraInicio;
                        }
                    }

                }
                Yii::$app->session->setFlash('success', "Agendamento realizado com sucesso.");
                return $this->redirect(['index']);
            }


            return $this->render('create', [
                'model' => $model,
                'diaSemanaArray' => $model->diaSemanaArray
            ]);


        } else {



            echo $model->diaSemanaArray;

            return $this->render('create', [
                'model' => $model,
                'diaSemanaArray' => $model->diaSemanaArray
            ]);

        }
    }

    /**
     * Updates an existing Agenda model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Deletes an existing Agenda model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAlteraStatus($id)
    {
        $model = $this->findModel($id);
        
        $model->status = '2';
        $model->save(false);

        return $this->redirect(['index']);
    }


    public function actionTurmas($id_terapeuta)
    {

        $countPosts = AlunoTurma::find()->select("Disciplina.nome as nome_da_disciplina, Turma.codigo as codigo_da_turma, Turma.id as id_da_turma")
                ->innerJoin("Turma","Turma.id = Aluno_Turma.Turma_id")
                ->innerJoin("Disciplina","Disciplina.id = Turma.Disciplina_id")
                ->where(['Usuarios_id' => $id_terapeuta ])
                ->count();
 
        $posts = AlunoTurma::find()->select("Disciplina.nome as nome_da_disciplina, Turma.codigo as codigo_da_turma, Turma.id as id_da_turma")
                ->innerJoin("Turma","Turma.id = Aluno_Turma.Turma_id")
                ->innerJoin("Disciplina","Disciplina.id = Turma.Disciplina_id")
                ->where(['Usuarios_id' => $id_terapeuta ])
                ->all();
 
        if($countPosts>0){
                echo '<option value="default" disabled selected="selected"> Selecione uma opção </option>';
            foreach($posts as $post){
                echo "<option value='".$post->id_da_turma."'>Disciplina: ".$post->nome_da_disciplina." - Turma: ".$post->codigo_da_turma."</option>";
            }
        }
        else{
            echo '<option value="default" disabled selected="selected"> Não há Disciplina/Turma para esse Usuário </option>';
        }
 
    }


    /**
     * Finds the Agenda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Agenda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agenda::find()->where(['id' => $id, 'Usuarios_id' => Yii::$app->user->id, 'status' => '1'])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
