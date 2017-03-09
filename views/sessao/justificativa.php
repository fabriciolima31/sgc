<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioPaciente */

$this->title = "Sessão não Ocorrida";
$this->params['breadcrumbs'][] = ['label' => 'Sessão Não Ocorrida', 'url' => ['sessao/all', 'id'=> Yii::$app->request->get('idPaciente') ]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-paciente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'observacao')->textarea(['rows' => 6])->label("<font color='#FF0000'>*</font> <b>Justificativa?</b>"); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' , ]) ?>
    </div>

        <?php ActiveForm::end(); ?>


</div>
