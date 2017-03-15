<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use kartik\mpdf\Pdf;
use app\models\Relatorio;


/**
 * AlunoTurmaController implements the CRUD actions for AlunoTurma model.
 */
class RelatorioController extends Controller
{

    public function actionReport()
    {

    $model = new Relatorio();
    $html = $model->getHtmlParaRelatorio();

    $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER, 
        // your html content input
        'content' => $html,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Krajee Report Title'],
         // call mPDF methods on the fly
        'methods' => [ 
            'SetHeader'=>['Relatório'], 
            'SetFooter'=>['{PAGENO}'],
        ]
    ]);

    Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    Yii::$app->response->headers->add('Content-Type', 'application/pdf');


    return $pdf->render();

    }


}
