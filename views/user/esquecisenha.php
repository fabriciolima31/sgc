<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Esqueci Minha Senha';
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar Senha';
?>
<div class="user-update">

    <?= $this->render('_form_esqueci_senha', [
        'model' => $model,
    ]) ?>

</div>
