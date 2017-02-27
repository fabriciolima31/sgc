<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = 'Ficha de Solicitação de Atendimento Psicoterápico - CSPA ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paciente-create">

    <h1 align="center" ><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
