<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Turma;
use app\models\User;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\AlunoTurma */
/* @var $form yii\widgets\ActiveForm */

$turmas = Turma::find()->select("Disciplina.nome as nome_da_disciplina, Turma.*")
        ->innerJoin("Disciplina","Disciplina.id = Turma.Disciplina_id")
        ->where("data_fim >= CURDATE()")
        ->all();
$usuarios = ArrayHelper::map(User::find()->where(['tipo' => '3', 'status' => '1'])->orderBy('nome')->all(), 'id', 'nome');

?>

<div class="aluno-turma-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Turma_id')->dropDownList(ArrayHelper::map($turmas,'id',function($model, $defaultValue) {
                        return $model['nome_da_disciplina'].' - Turma: '.$model['codigo'];
                }),['prompt'=>'Escolha uma Disciplina e Turma'])->label("<font color='#FF0000'>*</font> <b>Turma:</b>") 
        ?>   
    <?=
        $form->field($model, 'Usuarios_id')->widget(Select2::classname(), [
            'data' => $usuarios,
            'language' => 'pt',
            'options' => ['placeholder' => 'Selecione um Aluno'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label("<font color='#FF0000'>*</font> <b>Aluno:</b>");
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Alocar' : 'Alocar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
