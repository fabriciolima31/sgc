<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioPaciente */

$this->title = "Sessão não Ocorrida";
$this->params['breadcrumbs'][] = ['label' => 'Sessões', 'url' => ['sessao/all', 'id'=> Yii::$app->request->get('idPaciente') ]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-paciente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pacienteFalta')->dropDownList($model->statusNODescArray,['prompt' => 'Selecione um Motivo.'])->label("<font color='#FF0000'>*</font> <b>Motivo</b>") ?>
    
    <?= $form->field($model, 'observacao')->textarea(['rows' => 6])->label("<font color='#FF0000'>*</font> <b>Descrição</b>"); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' , ]) ?>
    </div>

        <?php ActiveForm::end(); ?>


</div>
