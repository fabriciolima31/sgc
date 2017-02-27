<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioTurmaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuario Turmas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-turma-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Usuario Turma', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Turma_id',
            'Usuarios_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
