<?php

namespace app\models;

use yii\helpers\Security;
use yii\web\IdentityInterface;
use yiibr\brvalidator\CpfValidator;
use app\models\Disciplina;

/**
 * This is the model class for table "tbl_user".
 *
 * @property string $id
 * @property string $cpf
 * @property string $password
 */
class User extends \yii\db\ActiveRecord  implements IdentityInterface
{
    public $password_repeat;
    public $turmasArray;

    public $quantidade_atendimentos;
    public $data_inicio;
    public $data_fim;

   /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpf', 'nome', 'tipo', 'email'], 'required'],
            [['password','password_repeat'], 'required','on'=> 'create'],
            [['password','password_repeat'], 'required','on'=> 'updatesenha'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'E-mail informado já cadastrado.'],
            [['turmasArray'], 'validateTurmas'],
            [['cpf'], 'string'],
            [['cpf'],  CpfValidator::className(), 'message' => 'CPF Inválido'],
            [['email'], 'email'],
            [['status'], 'string'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Esta senha não é igual à anterior" ],
            [['auth_key'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => 6, 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'cpf' => 'CPF',
            'password' => 'Senha',
            'nome' => 'Nome',
            'tipo' => 'Perfil',
            'status' => 'Status',
            'password_repeat' => 'Repetir Senha',
            'email' => 'E-mail',
            'turmasArray' => 'Disciplina - Turma'
        ];
    }
    
    public function beforeSave($insert){
        $this->password = sha1("SGC".$this->password);
        return true;
    }
    
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
/* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }
    /**
     * Finds user by cpf
     *
     * @param  string      $cpf
     * @return static|null
     */
    public static function findByUsername($cpf)
    {
        return static::findOne(['cpf' => $cpf]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validateTurmas($attribute){
        if (!$this->hasErrors()) {


        $model_disciplinas_turmas = Disciplina::find()
        ->select("Disciplina.id as disc_id, Turma.id as turma_id")
        ->innerJoin("Turma","Disciplina.id = Turma.Disciplina_id")
        ->where('Turma.id IN ('. implode(',',$this->turmasArray).')')->asArray()->all();
;
       
        $incrementador = 0;
        for($i=0; $i < count($model_disciplinas_turmas) ; $i++){
            for($j=$i+1; $j < count($model_disciplinas_turmas); $j++ ){
                if($model_disciplinas_turmas[$i]["disc_id"] == $model_disciplinas_turmas[$j]["disc_id"] ){ 
                    $incrementador ++;
                    break;
                }
            }
        }

            if ($incrementador > 0) {
                $this->addError($attribute, 'Voce escolheu disciplinas Iguais.');
            }
        }
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === sha1("SGC".$password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Security::generatePasswordHash('SGC'.$password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public function getPerfil($perfil)
    {
        if ($perfil == 1) {
            return "Professores";
        } else if ($perfil == 2) {
            return "Psicólogos";
        } else if ($perfil == 3) {
            return "Terapeutas";
        } else if ($perfil == 4) {
            return "Administradores";
        } else {
            return "Todos";
        }
    }
    
    public function getPerfilDesc()
    {
        if ($this->status == '1') {
            return "Professores";
        } else if ($this->status == '2') {
            return "Psicólogos";
        } else if ($this->status == '3') {
            return "Terapeutas";
        } else if ($this->status == '4') {
            return "Administradores";
        } else {
            return "Desconhecido";
        }
    }
    
    
    /*
     * Verifica a existência de um usário ativo
     * retorna null ou User object
     **/
    public function getExistenteUsuario()
    {
        $user = User::find()->where(['cpf' => $this->cpf])->one();
        
        if ($user != null) {
            if ($user->status == "1") {
                $this->addError('cpf', "CPF já cadastrado.");
                return 1;
            } else {
                $user->status = "1";
                $user->nome = $this->nome;
                $user->tipo = $this->tipo;
                $user->email = $this->email;
                $user->password = $this->password;
                $user->password_repeat = $this->password_repeat;
                return $user;
            }
        }
        return 0;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlunoTurmas()
    {
        return $this->hasMany(AlunoTurma::className(), ['Usuarios_id' => 'id']);
    }

    public function gerarSenhaParaEsqueciSenha(){

        //DETERMINA OS CARACTERES QUE CONTERÃO A SENHA
        $caracteres = "0123456789abcdefghijklmnopqrstuvwxyz+-/()";
        //EMBARALHA OS CARACTERES E PEGA APENAS OS 10 PRIMEIROS
        $mistura = substr(str_shuffle($caracteres),0,10);
        //EXIBE O RESULTADO
        return $mistura;
        
    }

    public function getConteudoEmailEsqueciSenha($nome_do_usuario_que_quer_trocar_a_senha, $senha){
        $html = "<h3> Olá, ".$nome_do_usuario_que_quer_trocar_a_senha.".</h3>";
        $html .= "Você Solicitou o Serviço <b>Esqueci minha Senha<b>!<br><br>";
        $html .= "Portanto, geramos uma senha nova para você: <b>".$senha."</b>";
        $html .= "<br><br>";
        $html .= "-Sistema de Gerenciamento de Consultas - Universidade Federal do Amazonas.<br><br>";
        $html .= "Obs.: Este e-mail foi gerado automaticamente, não o responda!";
        return $html;

    }
}