<?php

namespace app\controllers;

use Yii;
use app\models\UsuarioPaciente;
use app\models\Paciente;
use app\models\UsuarioPacienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * UsuarioPacienteController implements the CRUD actions for UsuarioPaciente model.
 */
class UsuarioPacienteController extends Controller
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
           /* 'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index','update','view', 'delete'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->tipo == '4';
                        }
                    ],
                    // everything else is denied
                ],
            ],*/
        ];
    }

    /**
     * Lists all UsuarioPaciente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioPacienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsuarioPaciente model.
     * @param string $Paciente_id
     * @param integer $Usuario_id
     * @param string $status
     * @return mixed
     */
    public function actionView($Paciente_id, $Usuario_id, $status)
    {
        return $this->render('view', [
            'model' => $this->findModel($Paciente_id, $Usuario_id, $status),
        ]);
    }

    /**
     * Creates a new UsuarioPaciente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new UsuarioPaciente();
        $existe_usuario_paciente = UsuarioPaciente::find()->where(["Paciente_id" => $id])->andWhere(["status" => "1"])->count();
       
        $paciente = Paciente::find()->where(['id'=> $id])->One();

        $model->Paciente_id = $id;
        $model->status = '1';


       
        if ($existe_usuario_paciente == 0 && $model->load(Yii::$app->request->post()) && $model->save()) {
            $paciente->setStatus("Alocar");
            return $this->redirect(['paciente/index', 'status' => 'EC']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'existe_usuario_paciente' => $existe_usuario_paciente ,
            ]);
        }
    }

    /**
     * Updates an existing UsuarioPaciente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $Paciente_id
     * @param integer $Usuario_id
     * @param string $status
     * @return mixed
     */
    public function actionUpdate($Paciente_id, $Usuario_id, $status)
    {
        $model = $this->findModel($Paciente_id, $Usuario_id, $status);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Paciente_id' => $model->Paciente_id, 'Usuario_id' => $model->Usuario_id, 'status' => $model->status]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UsuarioPaciente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $Paciente_id
     * @param integer $Usuario_id
     * @param string $status
     * @return mixed
     */
    public function actionDelete($Paciente_id, $Usuario_id, $status)
    {
        $this->findModel($Paciente_id, $Usuario_id, $status)->delete();

        return $this->redirect(['index']);
    }

    public function actionEncaminhar($id)
    {
            
        /*           
                    $paciente = Paciente::find()->where(["id" => $Paciente_id])->one();
                    $paciente->status = "LE";
                    $paciente->save();

                    $usuarioPaciente = UsuarioPaciente::find()->where(["Paciente_id" => $Paciente_id ])->andWhere(["status" => "1"])->one();
                    $usuarioPaciente->status = "0";
                    $usuarioPaciente->save();

        return $this->redirect(['paciente/meus-pacientes', 'status' => 'EC']);
        */

        $paciente = $this->findPaciente($id);
        $paciente->status = "LE";

        $model = UsuarioPaciente::find()->where(["Paciente_id" => $id ])->andWhere(["status" => "1"])->one();
        $model->status = '0';
        $model->scenario = $this->action->id; //cenário criado para deixar como obrigatório a justificativa(observação)
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $paciente->save();
            return $this->redirect(['paciente/meus-pacientes', 'status' => 'EC']);
        }
        else{

            return $this->render('justificativa', [
                'model' => $model,
           ]);
        }
   
    }

    /**
     * Finds the UsuarioPaciente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $Paciente_id
     * @param integer $Usuario_id
     * @param string $status
     * @return UsuarioPaciente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Paciente_id, $Usuario_id, $status)
    {
        if (($model = UsuarioPaciente::findOne(['Paciente_id' => $Paciente_id, 'Usuario_id' => $Usuario_id, 'status' => $status])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findPaciente($Paciente_id)
    {
        if (($model = Paciente::find()->where(["id" => $Paciente_id, 'status' => 'EC'])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Página solicitada não existe.');
        }
    }
}
