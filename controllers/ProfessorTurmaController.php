<?php

namespace app\controllers;

use Yii;
use app\models\ProfessorTurma;
use app\models\ProfessorTurmaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfessorTurmaController implements the CRUD actions for UsuarioTurma model.
 */
class ProfessorTurmaController extends Controller
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
                'only' => ['index', 'view', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@' ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all UsuarioTurma models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfessorTurmaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsuarioTurma model.
     * @param integer $Turma_id
     * @param integer $Usuarios_id
     * @return mixed
     */
    public function actionView($Turma_id, $Usuarios_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($Turma_id, $Usuarios_id),
        ]);
    }

    /**
     * Creates a new UsuarioTurma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProfessorTurma();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "'".$model->usuarios->nome."' foi alocado para a turma '".$model->turma->codigo."'.");
            return $this->redirect(['view', 'Turma_id' => $model->Turma_id, 'Usuarios_id' => $model->Usuarios_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UsuarioTurma model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Turma_id
     * @param integer $Usuarios_id
     * @return mixed
     */
    public function actionUpdate($Turma_id, $Usuarios_id)
    {
        $model = $this->findModel($Turma_id, $Usuarios_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Turma_id' => $model->Turma_id, 'Usuarios_id' => $model->Usuarios_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UsuarioTurma model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Turma_id
     * @param integer $Usuarios_id
     * @return mixed
     */
    public function actionDelete($Turma_id, $Usuarios_id)
    {
        $this->findModel($Turma_id, $Usuarios_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UsuarioTurma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Turma_id
     * @param integer $Usuarios_id
     * @return UsuarioTurma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Turma_id, $Usuarios_id)
    {
        if (($model = ProfessorTurma::findOne(['Turma_id' => $Turma_id, 'Usuarios_id' => $Usuarios_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
