<?php

namespace app\controllers;

use Yii;
use app\models\Agenda;
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
     * @param integer $Consultorio_id
     * @param integer $Usuarios_id
     * @param string $diaSemana
     * @param string $horaInicio
     * @param string $status
     * @return mixed
     */
    public function actionView($Consultorio_id, $Usuarios_id, $diaSemana, $horaInicio, $status)
    {
        return $this->render('view', [
            'model' => $this->findModel($Consultorio_id, $Usuarios_id, $diaSemana, $horaInicio, $status),
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Consultorio_id' => $model->Consultorio_id, 'Usuarios_id' => $model->Usuarios_id, 'diaSemana' => $model->diaSemana, 'horaInicio' => $model->horaInicio, 'status' => $model->status]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Agenda model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Consultorio_id
     * @param integer $Usuarios_id
     * @param string $diaSemana
     * @param string $horaInicio
     * @param string $status
     * @return mixed
     */
    public function actionUpdate($Consultorio_id, $Usuarios_id, $diaSemana, $horaInicio, $status)
    {
        $model = $this->findModel($Consultorio_id, $Usuarios_id, $diaSemana, $horaInicio, $status);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Consultorio_id' => $model->Consultorio_id, 'Usuarios_id' => $model->Usuarios_id, 'diaSemana' => $model->diaSemana, 'horaInicio' => $model->horaInicio, 'status' => $model->status]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Agenda model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Consultorio_id
     * @param integer $Usuarios_id
     * @param string $diaSemana
     * @param string $horaInicio
     * @param string $status
     * @return mixed
     */
    public function actionDelete($Consultorio_id, $Usuarios_id, $diaSemana, $horaInicio, $status)
    {
        $this->findModel($Consultorio_id, $Usuarios_id, $diaSemana, $horaInicio, $status)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Agenda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Consultorio_id
     * @param integer $Usuarios_id
     * @param string $diaSemana
     * @param string $horaInicio
     * @param string $status
     * @return Agenda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Consultorio_id, $Usuarios_id, $diaSemana, $horaInicio, $status)
    {
        if (($model = Agenda::findOne(['Consultorio_id' => $Consultorio_id, 'Usuarios_id' => $Usuarios_id, 'diaSemana' => $diaSemana, 'horaInicio' => $horaInicio, 'status' => $status])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
