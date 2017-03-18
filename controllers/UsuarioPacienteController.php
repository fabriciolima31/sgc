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
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'create', 'encaminhar-terapeuta'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->tipo == '4';
                        }
                    ],
                ],
            ],
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
     * Creates a new UsuarioPaciente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new UsuarioPaciente();
        $existe_usuario_paciente = UsuarioPaciente::find()->where(["Paciente_id" => $id])->andWhere(["status" => "1"])->count();

        $historicoTerapeutasAnterioresAoPaciente = $model->listarHistoricoTerapeutasDoPaciente($id);

        $paciente = Paciente::find()->where(['id'=> $id])->One();

        $model->Paciente_id = $id;
        $model->status = '1';

        $terapeutas = $model->gerarListaDeTerapeutas();
       
        if ($existe_usuario_paciente == 0 && $model->load(Yii::$app->request->post()) && $model->save()) {
            $paciente->setStatus("Alocar");
            Yii::$app->session->setFlash('success', "Paciente alocado com sucesso.");
            return $this->redirect(["paciente/index", 'status' => 'EC']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'existe_usuario_paciente' => $existe_usuario_paciente ,
                'terapeutas' => $terapeutas,
                'historicoTerapeutasAnterioresAoPaciente' => $historicoTerapeutasAnterioresAoPaciente,
            ]);
        }
    }

    
    /*ACESSO COMPARTILHADO*/
    public function actionEncaminhar($id)
    {
        $paciente = $this->findPaciente($id);
        $paciente->status = "DV";
        
        $model = UsuarioPaciente::find()->where(["Paciente_id" => $id ])->andWhere(["status" => "1"])->one();
        $model->status = '0';
        $model->scenario = $this->action->id; //cenário criado para deixar como obrigatório a justificativa(observação)
       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $paciente->fecharSessoes();
            $paciente->save();
            Yii::$app->session->setFlash('success', "Paciente encaminhado para Lista de Espera com sucesso.");
            return $this->redirect(['paciente/meus-pacientes', 'status' => 'EC']);
        }
        else{
            return $this->render('justificativa', [
                'model' => $model,
           ]);
        }
    }
    
    public function actionEncaminharTerapeuta($id)
    {
        $model = new UsuarioPaciente();
        $existente = UsuarioPaciente::find()->where(["Paciente_id" => $id])->andWhere(["status" => "1"])->one();
       
        $paciente = Paciente::find()->where(['id'=> $id])->One();

        $historicoTerapeutasAnterioresAoPaciente = $model->listarHistoricoTerapeutasDoPaciente($id);
        
        $model->Paciente_id = $id;
        $model->status = '1';
        $existente->status = '0';
       
        $terapeutas = $model->gerarListaDeTerapeutas();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $paciente->fecharSessoes();
            $paciente->setStatus("Alocar");
            $existente->save();
            Yii::$app->session->setFlash('success', "Paciente encaminhado para o terapeuta '".$model->usuario->nome."'.");
            return $this->redirect(["paciente/index", 'status' => 'EC']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'existe_usuario_paciente' => 0 ,
                'terapeutas' => $terapeutas,
                'historicoTerapeutasAnterioresAoPaciente' => $historicoTerapeutasAnterioresAoPaciente,
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
        if (($model = Paciente::find()->where(["id" => $Paciente_id])->andWhere('status = \'EC\' OR status = \'EA\'')->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Página solicitada não existe.');
        }
    }
    
    protected function findAlocacao($id)
    {
        if (($model = UsuarioPaciente::find()->where(["id" => $id])->andWhere('status = \'1\'')->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Página solicitada não existe.');
        }
    }
}
