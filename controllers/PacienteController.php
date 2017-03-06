<?php

namespace app\controllers;

use Yii;
use app\models\Paciente;
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
                'only' => ['index'],
                'rules' => [
                    [
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
     * Lists all Paciente models.
     * @return mixed
     */
    public function actionIndex($status)
    {
        $params['status'] = Yii::$app->request->queryParams['status'];
        
        $searchModel = new PacienteSearch();
        $dataProvider = $searchModel->search($params);
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
        $params['status'] = Yii::$app->request->queryParams['status'];

        $searchModel = new PacienteSearch();
        $dataProvider = $searchModel->searchMeusPacientes($params);

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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            //return print_r($model->getErrors());
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Paciente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
       return "SERÀ MUDAR STATUS";
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
            $model = Paciente::find()->where(['id' => $id])->joinWith("usuario_Paciente")->andWhere(['Usuario_id' => Yii::$app->user->id, 'Usuario_Paciente.status' => '1'])->One();
        } else{
            $model = Paciente::find()->where(['id' => $id])->One();
        }


        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
