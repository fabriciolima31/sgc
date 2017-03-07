<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Autenticação';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor, preencha os campos abaixo para efetuar o login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'cpf')->textInput(['autofocus' => true])->widget(MaskedInput::className(), [
            'mask' => '999.999.999-99',]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div style="margin-bottom: 2%">
            <?= Html::submitButton('Efetuar Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?= Html::a('Novo Cadastro', ['user/create'], ['class' => 'btn btn-info']) ?>
        </div>


    <?php ActiveForm::end(); ?>

    <div class="col-lg-offset-1" style="color:#999;">

    </div>
</div>
