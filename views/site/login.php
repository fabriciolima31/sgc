<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div style="width: 100%;text-align: center; margin-top: 5%; font-size: 250%"> 
    <a href="#"> <b>Sistema de Gerenciamento de Consultas</b> </a>
    <br> 
    <a href="#"> <b>Universidade Federal do Amazonas</b> </a> 
</div>

<div class="login-box">
    <div class="login-logo">
        
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Efetue o login com seu CPF e senha:</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'cpf', $fieldOptions1)
            ->label("CPF")
            ->widget(MaskedInput::className(), ['mask' => '999.999.999-99',]);
            //->textInput(['placeholder' => $model->getAttributeLabel('cpf')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label("Senha")
            ->passwordInput() ?>

        <div class="row">
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <div class="social-auth-links text-center">
            <!--
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in
                    using Facebook</a>
                <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign
                    in using Google+</a>
            -->
        </div>
        <!-- /.social-auth-links -->

        <a href="index.php?r=user/esquecisenha">Eu Esqueci minha Senha!</a><br>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
