<?php

namespace app\controllers;

use Yii;
use app\models\Agenda;
use app\models\Consultorio;
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
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@' ],
                    ],
                    [
                        'actions' => ['create', 'altera-status', 'delete', 'turmas', 'index-calendario'],
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
    
    
    /*Geração das reservas dos consultórios*/
    
    public function actionIndexCalendario($idConsultorio)
    {
        
        $searchModel = new AgendaSearch();
        $dataProvider = $searchModel->searchAllModels(Yii::$app->request->queryParams);
        
        $modelConsultorio = Consultorio::findAll(['status' => '1']);
    
        $reservas = array();
        
        foreach($dataProvider->all() as $reserva){
            $Reservas = new \yii2fullcalendar\models\Event();
            $Reservas->id = $reserva->id;
            $Reservas->title = $reserva->user->nome;
            $Reservas->start = Agenda::converterDatas_para_AAAA_MM_DD_com_Retorno($reserva->data_inicio)."T".$reserva->horaInicio;
            $Reservas->end = Agenda::converterDatas_para_AAAA_MM_DD_com_Retorno($reserva->data_fim)."T".$reserva->horaFim;
            $reservas[] = $Reservas;
        }
        
        return $this->render('indexcalendario', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'reservas' => $reservas,
            'modelConsultorio' => $modelConsultorio
        ]);
    }
    
    

    /**
     * Displays a single Agenda model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderPartial('view', [
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

    public function actionAlteraStatus($id)
    {
        if (Yii::$app->user->identity->tipo == '4') {
            $model = $this->findModel($id);
        } else {
            $model = $this->findYourAgenda($id);
        }

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
                ->andWhere("Turma.data_fim > CURDATE()")
                ->count();
 
        $posts = AlunoTurma::find()->select("Disciplina.nome as nome_da_disciplina, Turma.codigo as codigo_da_turma, Turma.id as id_da_turma")
                ->innerJoin("Turma","Turma.id = Aluno_Turma.Turma_id")
                ->innerJoin("Disciplina","Disciplina.id = Turma.Disciplina_id")
                ->where(['Usuarios_id' => $id_terapeuta ])
                ->andWhere("Turma.data_fim > CURDATE()")
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
        if (($model = Agenda::find()->where(['id' => $id, 'status' => '1'])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findYourAgenda($id)
    {
        if (($model = Agenda::find()->where(['id' => $id, 'status' => '1', 'id' => Yii::$app->user->id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
