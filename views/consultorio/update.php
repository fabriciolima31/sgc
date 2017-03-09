<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Consultorio */

$this->title = 'Editar Consultório: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Consultórios', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="consultorio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
