<?php

namespace app\models;

use yii\helpers\Security;
use yii\web\IdentityInterface;
use yiibr\brvalidator\CpfValidator;

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
            [['cpf', 'password', 'nome', 'tipo', 'email'], 'required'],
            [['cpf'], 'string'],
            //[['cpf'],  CpfValidator::className(), 'message' => 'CPF Inválido'],
            [['email'], 'email'],
            [['status'], 'string'],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Esta senha não é igual à anterior" ],
            [['auth_key'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => 6, 'max' => 15],
            [['Turma_id'], 'integer']
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
            'email' => 'Email',
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
        $this->password_hash = Security::generatePasswordHash($password);
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
    
    public function getPerfil()
    {
        if ($this->tipo == 1) {
            return "Professor";
        } else if ($this->tipo == 2) {
            return "Psicólogo";
        } else if ($this->tipo == 3) {
            return "Terapeuta";
        } else {
            return "Administrador";
        }
    }
    
    public function getTurma()
    {
        return $this->hasOne(Turma::className(), ['id' => 'Turma_id']);
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
}