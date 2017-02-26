<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sessao */

$this->title = 'Create Sessao';
$this->params['breadcrumbs'][] = ['label' => 'Sessaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sessao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
