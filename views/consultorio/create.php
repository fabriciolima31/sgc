<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Consultorio */

$this->title = 'Criar Novo Consultório';
$this->params['breadcrumbs'][] = ['label' => 'Consultorios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultorio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
