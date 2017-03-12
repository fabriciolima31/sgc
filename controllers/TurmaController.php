<?php

namespace app\controllers;

use Yii;
use app\models\Turma;
use app\models\ProfessorTurma;
use app\models\TurmaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TurmaController implements the CRUD actions for Turma model.
 */
class TurmaController extends Controller
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
                'only' => ['index', 'all', 'update','view', 'delete'],
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
     * Lists all Turma models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TurmaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Displays a single Turma model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        //$model->data_inicio = $this->converterDatas_para_DD_MM_AAAA($model->data_inicio); 
        //$model->data_fim = $this->converterDatas_para_DD_MM_AAAA($model->data_fim);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Turma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Turma();
        $model_ProfessorTurma = new ProfessorTurma();

        if ($model->load(Yii::$app->request->post())) {

            //as duas linhas abaixo convertem as data de  DD-MM-AAAA para AAAA-MM-DD
            //$model->data_inicio = $this->converterDatas_para_AAAA_MM_DD($model->data_inicio); 
            //$model->data_fim = $this->converterDatas_para_AAAA_MM_DD($model->data_fim);
            
            if ($model->save()){

                $model_ProfessorTurma->Turma_id = $model->id;
                $model_ProfessorTurma->Usuarios_id = $model->Professor_id;
                $model_ProfessorTurma->save();

               return $this->redirect(['view', 'id' => $model->id]);
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
     * Updates an existing Turma model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if($model->save()){
               return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Turma model.
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
     * Finds the Turma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Turma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Turma::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function converterDatas_para_AAAA_MM_DD($data) {

        $ano = substr($data,6,4); //pega os 4 ultimos caracteres, a contar do índice 4
        $mes = substr($data,3,2); //pega os 2 caracteres, a contar do índice 2
        $dia = substr($data,0,2); //pega os 2 caracteres, a contar do índice 0
        $data_formatada = $ano."-".$mes."-".$dia;
        return $data_formatada; //retorna data formatada: AAAA-MM-DD
    }

    public function converterDatas_para_DD_MM_AAAA($data) {

        $ano = substr($data,0,4); //pega os 4 ultimos caracteres, a contar do índice 4
        $mes = substr($data,5,2); //pega os 2 caracteres, a contar do índice 2
        $dia = substr($data,8,2); //pega os 2 caracteres, a contar do índice 0
        $data_formatada = $dia."-".$mes."-".$ano;
        return $data_formatada; //retorna data formatada: AAAA-MM-DD
    }
}
