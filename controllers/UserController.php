<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\AlunoTurma;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],


            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@' ],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->tipo == '4';
                        }
                    ],
                    [
                        'actions' => ['index', 'delete'],
                        'allow' => true,
                        'roles' => ['@' ],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->tipo != '4';
                        }
                    ],
                    [
                        //Verificar como ficar o update (cada usuaŕio ou estagiário)
                        'actions' => ['update', 'view', 'updatesenha'],
                        'allow' => true,
                        'roles' => ['@' ],
                    ],
                    [
                        'actions' => ['create','esquecisenha'],
                        'allow' => true,
                        'roles' => ['@' , '?'],
                    ],
                            
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (isset(Yii::$app->request->queryParams['perfil'])) {
            $params['perfil'] = Yii::$app->request->queryParams['perfil'];
        } else {
            $params['perfil'] = "";
        }

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($params);
        
        $perfil = User::getPerfil($params['perfil']);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perfil' => $perfil,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        $model->scenario = $this->action->id; //cenário criado para deixar como obrigatório a senha e repetir senha.
        
        if ($model->load(Yii::$app->request->post())) {
            if($model->existenteUsuario != '1'){
                if ($model->existenteUsuario != '0') {
                    $model = $model->existenteUsuario;
                }

                if ($model->save()) {

                    if ($model->tipo == 3){

                        $aluno_turma = new AlunoTurma();

                            $i=0;

                            if($model->turmasArray == ""){
                                $frag = false;
                            }
                            else{
                                $frag = true;
                            }


                            while ($frag && $i < count($model->turmasArray)){
                                $aluno_turma->isNewRecord = true;
                                $aluno_turma->Usuarios_id = $model->id;
                                $aluno_turma->Turma_id = $model->turmasArray[$i];
                                $aluno_turma->save();
                                $i++;
                            }
                        
                    }
                    Yii::$app->session->setFlash('success', "'".$model->perfil."' cadastrado com sucesso.");
                    return $this->redirect(['view', 'id' => $model->id]);

                }else{
                    Yii::$app->session->setFlash('danger', "Erro ao cadastrar usuário.");
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $senha = $model->password;
        $model->password = "";

        if ($model->load(Yii::$app->request->post())){

            $atributos = $model->attributes();
            $atributos = array_diff($atributos, ["password","cpf"]);

            if($model->save(true,$atributos)) {
                Yii::$app->session->setFlash('success', "'".$model->nome."' alterado com sucesso.");
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('danger', "Erro ao alterar usuário.");
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdatesenha($id)
    {
        $model = $this->findModel($id);
        $senha = $model->password;
        $model->password = "";

        $model->scenario = $this->action->id; //cenário criado para deixar como obrigatório a senha e repetir senha.

        if ($model->load(Yii::$app->request->post())){

            $atributos = array("password");
            
            if($model->save(true,$atributos)) {
                Yii::$app->session->setFlash('success', "Senha alterada com sucesso.");
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('danger', "Erro ao alterar senha.");
                return $this->render('updatesenha', [
                    'model' => $model,
                ]);
            }


        } else {
            return $this->render('updatesenha', [
                'model' => $model,
            ]);
        }
    }

    public function actionEsquecisenha()
    {

        $model = new User();

        if ($model->load(Yii::$app->request->post())){ 

            $model = User::find()->where(["cpf" => $model->cpf])->one();

            $model->password = $model->gerarSenhaParaEsqueciSenha();

            $password_sem_criptografia = $model->password;

            if ($model->save()){

                $conteudoDoEmail = $model->getConteudoEmailEsqueciSenha($model->nome,$password_sem_criptografia);

                $x = Yii::$app->mailer->compose()
                ->setFrom('ufamsistemaconsulta@gmail.com')
                ->setTo($model->email)
                ->setSubject('Message subject')
                ->setTextBody('Plain text content')
                ->setHtmlBody($conteudoDoEmail)
                ->send();

                Yii::$app->session->setFlash('success', "Sua Senha foi encaminhada por seu E-mail");
                return $this->redirect(['site/index']);

            }




        }

        return $this->render('esquecisenha', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = '0';
        
        if (!$model->save(false)) {
            Yii::$app->session->setFlash('danger', "Erro ao remover Usuário.");
        }
        
        Yii::$app->session->setFlash('success', "Usuario removido com sucesso.");

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::find()->where(['id'=> $id,'status' => 1])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('A página solicitada não existe.');
        }
    }
}
