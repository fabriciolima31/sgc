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
                'only' => ['index', 'all', 'update','view', 'delete', 'altera-status'],
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
        $dataProvider = $searchModel->search(['Paciente_id' => $id]);

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
               
                return $this->redirect(['sessao/all', 'id' => $model->Paciente_id]);
            }
            else{
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

    /**
     * Deletes an existing Sessao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAlteraStatus($status, $idPaciente, $idSessao){
        
        $modelPacienteFalta = PacienteFalta::find()->where(['Paciente_id' => $idPaciente])->one();
        
        $model = Sessao::findOne(['id' => $idSessao]);
        $model->status = $status;
        $model->scenario = $this->action->id; //cenário criado para deixar como obrigatório a justificativa(observação)

        if($status == 'OS'){
                $modelPacienteFalta->FaltaNaoJustificada = 0;
                $model->observacao = "Sessão Realizada";
                $model->save();
                return $this->redirect(['sessao/all', 'id' => $idPaciente]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($model->pacienteFalta == 'PSJ'){
                $modelPacienteFalta->FaltaNaoJustificada++;
                $modelPacienteFalta->save();
            }else if($model->pacienteFalta == 'PCJ'){
                $modelPacienteFalta->FaltaNaoJustificada = 0;
                $modelPacienteFalta->FaltaJustificada++;
                $modelPacienteFalta->save();
            }
            
           return $this->redirect(['sessao/all', 'id' => $idPaciente]);
        }

        return $this->render('justificativa', [
                    'model' => $model,
        ]);
    }
    
    public function actionDatas($consultorio)
    {

        $countPosts = Agenda::find()
                ->where(['Consultorio_id' => $consultorio ])
                ->andWhere(['status' => 1])
                ->andWhere("data_inicio >= CURDATE()")
                ->count();
 
        $posts = Agenda::find()
                ->where(['Consultorio_id' => $consultorio])
                ->andWhere(['status' => 1])
                ->andWhere("data_inicio >= CURDATE()")
                ->orderBy('id ASC')
                ->all();


        if($countPosts>0){
                echo '<option value="default" disabled selected="selected"> Selecione uma opção </option>';
            foreach($posts as $post){
                echo "<option value='".$post->id."'>Dia: ".$post->data_inicio." às ".$post->horaInicio."</option>";
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
