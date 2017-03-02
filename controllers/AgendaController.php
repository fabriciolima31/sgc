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
     * Creates a new Agenda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Agenda();

        if ($model->load(Yii::$app->request->post())) {

            echo $model->horaInicio;
            echo $model->horaFim;

            $datetime1 = new \DateTime($model->data_inicio);
            $datetime2 = new \DateTime($model->data_fim);
            $interval = $datetime1->diff($datetime2);
            $diferencaDias =  abs($interval->format('%a'));
            $diferencaDias++;

            $auxDataInicio = $model->data_inicio;

            for($i=0; $i<$diferencaDias; $i++){

                $hora_incrementada= date('H:i',strtotime($model->horaInicio));
                $hora_limite = date('H:i',strtotime($model->horaFim));

                $dataDoLoop = date('d-m-Y',date(strtotime("+".$i." days", strtotime($auxDataInicio))));
                
                // 0 é domingo, 1 é segunda, 2 é terça, 3 é quarta, 4 é quinta, 5 é sexta, 6 é sábado
                $diaDaSemana = date('w', strtotime($dataDoLoop));


                $arras_semanas = array([0 => "Domingo" , 1 => 'Segunda-Feira', 2 => 'Terça-Feira', 3 => 'Quarta-Feira', 4 => 'Quinta-Feira', 5 => 'Sexta-Feira', 6 => 'Sábado' ]);


                if(in_array($diaDaSemana, $model->diaSemanaArray)) { 


                    while($hora_incrementada < $hora_limite){

                        $aux = $hora_incrementada;
                        $hora_incrementada =  date('H:i',strtotime($hora_incrementada) + 60*60);

                        $model->id = null;
                        $model->isNewRecord = true;
                        //$model->Usuarios_id = Yii::$app->user->id;
                        $model->diaSemana = $diaDaSemana;
                        $model->data_inicio = $dataDoLoop;
                        $model->data_fim = $dataDoLoop;
                        $auxHoraInicio = $model->horaInicio;
                        $model->horaInicio = $aux;
                        $auxHoraFim = $model->horaFim;
                        $model->horaFim = $hora_incrementada;
                        $model->status = '1';
                        $model->save();
                        $model->horaFim = $auxHoraFim;
                        $model->horaInicio = $auxHoraInicio;
                    }
                }

            }

            return $this->redirect(['index']);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Agenda model.
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
     * Deletes an existing Agenda model.
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
     * Finds the Agenda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Agenda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agenda::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
