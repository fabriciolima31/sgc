<?php

namespace app\controllers;

use Yii;
use app\models\Paciente;
use app\models\PacienteFalta;
use app\models\UsuarioPaciente;
use app\models\PacienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PacienteController implements the CRUD actions for Paciente model.
 */
 
class PacienteController extends Controller
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
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@' ],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->tipo == '4';
                        }
                    ],
                    [
                        'actions' => ['meus-pacientes'],
                        'allow' => true,
                        'roles' => ['@' ],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->tipo != '4';
                        }
                    ],
                    [
                        'actions' => ['update', 'view', 'alterar-status'],
                        'allow' => true,
                        'roles' => ['@' ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Paciente models.
     * @return mixed
     */
    public function actionIndex($status)
    {
        $params['status'] = Yii::$app->request->queryParams['status'];
        
        $searchModel = new PacienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $paciente = new Paciente();
        
        return $this->render('indexadministrador', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusDescricao' => $paciente->getStatus1($status),
        ]);
    }
    
    /**
     * Lists all Paciente models.
     * @return mixed
     */
    public function actionMeusPacientes($status)
    {
        $params['status'] = $status;

        $searchModel = new PacienteSearch();
        $dataProvider = $searchModel->searchMeusPacientes(Yii::$app->request->queryParams, $params['status']);

        $paciente = new Paciente();
                
        return $this->render('indexterapeuta', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusDescricao' => $paciente->getStatus1($params['status']),
        ]);
    }

    /**
     * Displays a single Paciente model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $this->findModel($id);
        
        $pacienteJaAlocado = (UsuarioPaciente::find()->where(['Paciente_id'=> $id])->andWhere(['status'=> 1])->count() == 1);
        $modelFaltas = PacienteFalta::find()->where(['Paciente_id' => $id])->one();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'pacienteJaAlocado' => $pacienteJaAlocado,
            'modelFaltas' => $modelFaltas,
        ]);
    }

    /**
     * Creates a new Paciente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Paciente();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Paciente cadastado com sucesso.");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Paciente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Paciente '".$model->nome."' foi alterado com sucesso.");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionAlterarStatus($id, $status)
    {
        $model = $this->findModel($id);
        
        $model->status = $status;
        
        $model->fecharSessoes();
        
        if($model->save()){
            Yii::$app->session->setFlash('success', "Status do paciente '".$model->nome."' alterado com sucesso.");
            if (Yii::$app->user->identity->tipo == '4') {
                return $this->redirect(['paciente/index', 'status' => $status]);
            } else {
                return $this->redirect(['paciente/meus-pacientes', 'status' => $status]);
            }
        }else{
            Yii::$app->session->setFlash('error', "Ocorreu um erro ao alterar status do paciente.");
        }
        if (Yii::$app->user->identity->tipo == '4') {
            return $this->redirect(['paciente/index', 'status' => 'LE']);
        } else {
            return $this->redirect(['paciente/meus-pacientes', 'status' => $status]);
        }
        
    }

    /**
     * Finds the Paciente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paciente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (Yii::$app->user->identity->tipo != '4') {
            $model = Paciente::find()->where(['Paciente.id' => $id])->joinWith("usuario_Paciente")->andWhere(['Usuario_id' => Yii::$app->user->id, 'Usuario_Paciente.status' => '1'])->One();
        } else{
            $model = Paciente::find()->where(['id' => $id])->One();
        }

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('A página solicitada não existe.');
        }
    }
}
