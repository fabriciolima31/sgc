<?php

namespace app\controllers;

use Yii;
use app\models\Sessao;
use app\models\Paciente;
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
        ];
    }

    /**
     * Lists all Sessao models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SessaoSearch();
        $dataProvider = $searchModel->searchPaciente(Yii::$app->request->queryParams);

        return $this->render('indexpaciente', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all Sessao models.
     * @return mixed
     */
    public function actionAll($id)
    {
        $searchModel = new SessaoSearch();
        $dataProvider = $searchModel->search(['Paciente_id' => $id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Paciente_id'
        ]);
    }

    /**
     * Displays a single Sessao model.
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
     * Creates a new Sessao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Sessao();
        $paciente = Paciente::find()->where(['id' => $id])->One();
        
        $model->data = date('d-m-Y');
        $model->Paciente_id = $id;
        $model->Usuarios_id = Yii::$app->user->id;
       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $paciente->status = 'AT';
            $paciente->save();
            $model->status = '1';
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            //return print_r($model->getErrors());
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Sessao model.
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
            return $this->render('update', [
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
}
