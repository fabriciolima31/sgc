<?php

namespace app\controllers;

use Yii;
use app\models\AlunoTurma;
use app\models\Turma;
use app\models\AlunoTurmaSearch;
use app\models\TurmaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;


/**
 * AlunoTurmaController implements the CRUD actions for AlunoTurma model.
 */
class AlunoTurmaController extends Controller
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
                'only' => ['index', 'index-alunos', 'view', 'delete', 'create'],
                'rules' => [
                    // allow authenticated users
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
     * Lists all AlunoTurma models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TurmaSearch();
        $dataProvider = $searchModel->searchTurmasAtivas(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all AlunoTurma models.
     * @return mixed
     */
    public function actionIndexAlunos($id)
    {
        $searchModel = new AlunoTurmaSearch();
        $dataProvider = $searchModel->searchAlunos( Yii::$app->request->queryParams , $id);
        
        $turma = Turma::find()->where(['id' => $id])->one();

        return $this->render('indexAlunos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id,
            'turma' => $turma,
        ]);
    }


    /**
     * Creates a new AlunoTurma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AlunoTurma();
        
        if (isset(Yii::$app->request->queryParams['id'])) {
            $model->Turma_id = Yii::$app->request->queryParams['id'];
        }

        if ($model->load(Yii::$app->request->post())) {

            
            if($model->checaAlocacao($model->Turma_id, $model->Usuarios_id) == null && $model->verificaSeAlunoJaEstaVinculadoTurma() == 0){

                if($model->save()){
                    Yii::$app->session->setFlash('success', "Aluno alocado para a turma com sucesso.");
                    return $this->redirect(['index-alunos', 'id' => $model->Turma_id]);
                }
            }
                
            return $this->render('create', [
                'model' => $model,
            ]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

//    public function actionReport()
//    {
//
//
//    $model = new AlunoTurma();
//    $html = $model->getHtmlParaRelatorio();
//
//    $pdf = new Pdf([
//        // set to use core fonts only
//        'mode' => Pdf::MODE_CORE, 
//        // A4 paper format
//        'format' => Pdf::FORMAT_A4, 
//        // portrait orientation
//        'orientation' => Pdf::ORIENT_PORTRAIT, 
//        // stream to browser inline
//        'destination' => Pdf::DEST_BROWSER, 
//        // your html content input
//        'content' => $html,  
//        // format content from your own css file if needed or use the
//        // enhanced bootstrap css built by Krajee for mPDF formatting 
//        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
//        // any css to be embedded if required
//        'cssInline' => '.kv-heading-1{font-size:18px}', 
//         // set mPDF properties on the fly
//        'options' => ['title' => 'Krajee Report Title'],
//         // call mPDF methods on the fly
//        'methods' => [ 
//            'SetHeader'=>['Relatório'], 
//            'SetFooter'=>['{PAGENO}'],
//        ]
//    ]);
//
//
//    return $pdf->render();
//
//    }

    /**
     * Deletes an existing AlunoTurma model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Turma_id
     * @param integer $Usuarios_id
     * @return mixed
     */
    public function actionDelete($Turma_id, $Usuarios_id)
    {
        $this->findModel($Turma_id, $Usuarios_id)->delete();
        
        Yii::$app->session->setFlash('success', "Aluno removido da turma com sucesso.");
        
        return $this->redirect(['index-alunos', 'id' => $Turma_id]);
    }

    /**
     * Finds the AlunoTurma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Turma_id
     * @param integer $Usuarios_id
     * @return AlunoTurma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Turma_id, $Usuarios_id)
    {
        if (($model = AlunoTurma::findOne(['Turma_id' => $Turma_id, 'Usuarios_id' => $Usuarios_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('A página solicitada não existe.');
        }
    }
    
}
