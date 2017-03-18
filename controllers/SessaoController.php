<?php

namespace app\controllers;

use Yii;
use app\models\Sessao;
use app\models\Paciente;
use app\models\PacienteFalta;
use app\models\Agenda;
use app\models\SessaoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SessaoController implements the CRUD actions for Sessao model.
 */
class SessaoController extends Controller
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
                'only' => ['index', 'all', 'update','view', 'delete', 'altera-status', 'datas'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->tipo == '3';
                        }
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }
    /**
     * Lists all Sessao models.
     * @return mixed
     */
    public function actionAll($id)
    {
        $this->checaPaciente($id);
        
        $paciente = Paciente::find()->where(['id' => $id])->One();
        
        $searchModel = new SessaoSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams, $id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'paciente' => $paciente,
        ]);
    }

    /**
     * Creates a new Sessao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $this->checaPaciente($id);
        
        $model = new Sessao();
        
        $paciente = Paciente::find()->where(['id' => $id])->One();
        
        if(PacienteFalta::find()->where(['Paciente_id' => $id])->one() == null){
            $pacienteFalta = new PacienteFalta();
            $pacienteFalta->Paciente_id = $id;
            $pacienteFalta->save();
        }
        
        $model->Paciente_id = $id;
        $model->Usuarios_id = Yii::$app->user->id;
        $model->status = 'EE';
        if ($model->load(Yii::$app->request->post())) {

            $model->Agenda_id = $model->data;
            $model->data = date('Y-m-d');
            
            if($model->save()){
                $paciente->setStatus("Sessao");
                $model->status = '1';
                
                $agenda = Agenda::find()->where(['id' => $model->Agenda_id])->One();
                
                $agenda->status = '0';
                $agenda->save(false);
               
                Yii::$app->session->setFlash('success', "Sessão adicionada com sucesso.");
                return $this->redirect(['sessao/all', 'id' => $model->Paciente_id]);
            }
            else{
                Yii::$app->session->setFlash('danger', "Ocorreu um erro ao adicionar a sessão.");
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionAlteraStatus($status, $idPaciente, $idSessao){
        
        $modelPacienteFalta = PacienteFalta::find()->where(['Paciente_id' => $idPaciente])->one();
        
        $model = Sessao::findOne(['id' => $idSessao]);
        $model->status = $status;
        $model->scenario = $this->action->id; //cenário criado para deixar como obrigatório a justificativa(observação)

        if($status == 'OS'){
                $modelPacienteFalta->FaltaNaoJustificadaSeguida = 0;
                $model->observacao = "Sessão Realizada";
                $model->save();
                Yii::$app->session->setFlash('success', "Registro de sessão como 'Ocorrida' efetuado com sucesso.");
                return $this->redirect(['sessao/all', 'id' => $idPaciente]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($model->pacienteFalta == 'PSJ'){
                $modelPacienteFalta->FaltaNaoJustificadaSeguida++;
                $modelPacienteFalta->FaltaNaoJustificada++;
                $modelPacienteFalta->save();
            }else if($model->pacienteFalta == 'PCJ'){
                $modelPacienteFalta->FaltaNaoJustificadaSeguida = 0;
                $modelPacienteFalta->FaltaJustificada++;
                $modelPacienteFalta->save();
            }
           Yii::$app->session->setFlash('success', "Registro de sessão efetuado com sucesso.");
           return $this->redirect(['sessao/all', 'id' => $idPaciente]);
        }

        return $this->render('justificativa', [
                    'model' => $model,
        ]);
    }
    
    public function actionDatas($consultorio)
    {
        $countPosts = Agenda::find()
                ->select("D.nome as nome_da_disciplina, T.*, Agenda.*")
                ->where(['Consultorio_id' => $consultorio ])
                ->innerJoin("Turma as T","T.id = Agenda.Turma_id")
                ->innerJoin("Disciplina as D","D.id = T.Disciplina_id")
                ->andWhere(['Agenda.status' => 1])
                ->andWhere("Agenda.data_inicio > CURDATE()")
                ->orWhere("Agenda.data_inicio = CURDATE() AND horaInicio >= CURTIME()")
                ->count();
 
        $posts = Agenda::find()
                ->select("D.nome as nome_da_disciplina, T.*, Agenda.*")
                ->innerJoin("Turma as T","T.id = Agenda.Turma_id")
                ->innerJoin("Disciplina as D","D.id = T.Disciplina_id")
                ->where(['Consultorio_id' => $consultorio])
                ->andWhere(['Agenda.status' => 1])
                ->andWhere("Agenda.data_inicio >= CURDATE()")
                ->orWhere("Agenda.data_inicio = CURDATE() AND horaInicio >= CURTIME()")
                ->orderBy('Agenda.data_inicio, nome_da_disciplina ASC')
                ->all();


        if($countPosts>0){
                echo '<option value="default" disabled selected="selected"> Selecione uma opção </option>';
            foreach($posts as $post){
                echo "<option value='".$post->id."'>Dia: ".$post->data_inicio." às ".$post->horaInicio." referente à disciplina: ".$post->nome_da_disciplina."</option>";
            }
        }
        else{
            echo '<option value="default" disabled selected="selected"> Não há Data e Horário </option>';
        }
 
    }

    /**
     * Finds the Sessao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sessao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sessao::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function checaPaciente($id){
        $model = \app\models\UsuarioPaciente::find()->where(['Usuario_id' => Yii::$app->user->id])->andWhere([
            'Paciente_id' => $id])->One();
        if($model == null){
            throw new NotFoundHttpException('A página solicitada não existe.');
        }
    }
}
