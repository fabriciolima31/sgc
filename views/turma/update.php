<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Turma */

$this->title = 'Editar Turma: ' . $model->ano."/".$model->semestre;
$this->params['breadcrumbs'][] = ['label' => 'Turmas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="turma-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
