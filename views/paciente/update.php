<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Paciente */

$this->title = 'Editar: ' . $model->nome;
if (Yii::$app->user->identity->tipo == '4'){
	$this->params['breadcrumbs'][] = ['label' => 'Pacientes', 'url' => ['index', 'status' => '']];
}
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="paciente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
