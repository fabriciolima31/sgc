<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Consultorio */

$this->title = 'Update Consultorio: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Consultorios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="consultorio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
