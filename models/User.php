<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $id
 * @property integer $nivel_permisos
 * @property string $email
 * @property string $password
 * @property string $nombre
 * @property string $apellidos
 * @property string $dni
 * @property string $direccion
 * @property string $tag_rfid
 *

 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey = 'b5eCNK2V+Xt71Ot8BAsFXxpZLYPurYbI+sZ+q9L8SP7b2T4+s/QUvJdPW7l7vqLEEj7oxp+9zQ0hrX7Uwn5P3g==';
    //public $accessToken;
    public $formPassword;
    public $formPasswordRepeat;
    public $sendPassword;

    public function getFullName()
    {
        return $this->nombre. ' ' .$this->apellidos;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nivel_permisos', 'nombre', 'apellidos'], 'required'],
            [['nivel_permisos', ], 'integer'],
            [['email', 'apellidos'], 'string', 'max' => 100],
            [['nombre'], 'string', 'max' => 50],
            [['dni'], 'string', 'max' => 9],
            [['tag_rfid'], 'unique'],
            /*[['password', 'sendPassword', 'formPassword'], 'required', 'on' => 'create'],*/
            [['password', 'tag_rfid', 'formPassword', 'formPasswordRepeat', 'sendPassword'], 'string', 'max' => 255],
            [
                'formPasswordRepeat',
                'compare',
                'compareAttribute' => 'formPassword',
                'message' => Yii::t('app', 'La contraseña debe coincidir.'),
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nivel_permisos' => 'Tipo de usuario',
            'email' => 'Email',
            'password' => 'Contraseña',
            'formPassword' => 'Contraseña',
            'formPasswordRepeat' => 'Repita contraseña',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'dni' => 'DNI',
            'direccion' => 'Direccion',
            'tag_rfid' => 'Tarjeta de identificación',
        ];
    }



    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        $dbUser = self::find()
                ->where([
                    "id" => $id
                ])
                ->one();
        if (!count($dbUser)) {
            return null;
        }
        //Yii::$app->session['nivel'] = $dbUser->nivel;
        return new static($dbUser);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        //return static::findOne(['email' => $username]);
        $dbUser = User::find()
                ->where([
                    "email" => $email
                ])
                ->one();

        if (!count($dbUser)) {
            return null;
        }
        //Yii::$app->session['nivel'] = $dbUser->nivel;
        return new static($dbUser);
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
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === hash('sha256', $password.'esta es una cadena para hacer el hasheo algo mas seguro');
    }

    public static function checkUserUpdatePassword($id) {
        if (!Yii::$app->permiso->isAdmin() && Yii::$app->user->id != $id) {
            throw new \yii\web\ForbiddenHttpException('No permitido');
        }
    }

    /**
     * Busca un usuario por el código RFID de su tarjeta y devuelve un array con
     * sus datos. Si no existe devuelve false.
     *
     * @param int $rfid
     * @return array|boolean
     */
    public static function getUserByRfid($rfid)
    {
        if (($user = User::find()->where(['tag_rfid' => $rfid])->select(['id', 'nombre', 'apellidos'])->asArray()->one())) {
            return $user;
        } else {
            return false;
        }
    }

    public static function getIdentityEmail()
    {
        return isset(Yii::$app->user->identity->email) ? Yii::$app->user->identity->email : false;
    }

    public function beforeSave($insert) {
        $this->dni = strtoupper($this->dni);
        $this->nombre = ucwords($this->nombre);
        $this->apellidos = ucwords($this->apellidos);
        if (parent::beforeSave($insert)) {
            if (!is_null($this->formPassword)) {
                $this->setAttribute('password', hash('sha256', $this->formPassword.'esta es una cadena para hacer el hasheo algo mas seguro'));
            }
            if ($this->tag_rfid == '') {
                $this->tag_rfid = null;
            }

            return true;
        } else {
            return false;
        }
    }



    /**
     * Se le pasa el modelo del usuario y envía un correo para activar su cuenta
     *
     * @param instanceof User $model
     */
    public function sendRecoveryEmail($model)
    {
        Yii::$app->mail->compose(['html' => 'sendRecoveryEmail'], ['model' => $model,
                                                                    'title' => Yii::t('app', 'Recuperación de contraseña'),
                                                                    'htmlLayout' => 'layouts/html'])
                ->setFrom(['info@inttegrum.com' => 'Castellón Pádel'])
                ->setTo([$model->email => $model->fullName])
                ->setSubject(Yii::t('app', 'Recuperación de contraseña'))
                ->send();
    }
}
