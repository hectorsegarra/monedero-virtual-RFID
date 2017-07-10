<?php

namespace app\controllers;

use Yii;
use app\components\InttegrumController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\LoginForm;
use app\models\User;
use app\models\Terminal;
use \yii\helpers\ArrayHelper;


class SiteController extends InttegrumController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'app\components\actions\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'transparent' => true,
            ],
        ];
    }



    public function actionRecoverPassword($email, $token)
    {
        $this->layout = 'main';
        if (($user = User::find()->where(['email' => $email])->one()) === null) {
            Yii::$app->session->setFlash('error-messages', 'No existe ninguna cuenta con este correo electrónico.');
            return $this->redirect(['site/error-messages']);
        }

        if ($user->estado == 0 || $token != $user->token) {
            Yii::$app->session->setFlash('error-messages', 'El enlace desde el que has accedido está caducado.');
            return $this->redirect(['site/error-messages']);
        }

        $datetime = new \DateTime($user->token_fecha, new \DateTimeZone('Europe/Madrid'));
        $datetime->add(\DateInterval::createFromDateString('+ 30minutes'));

        $now = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        if ($now > $datetime) {
            Yii::$app->session->setFlash('error-messages', 'El enlace desde el que has accedido está caducado.');
            return $this->redirect(['site/error-messages']);
        }

        if (($pass = Yii::$app->request->post('User'))) {
            $user->password = hash('sha256', $pass['formPassword'].'esta es una cadena para hacer el hasheo algo mas seguro');
            $user->token = null;
            $user->token_fecha = null;
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Tu contraseña ha sido cambiada. Ahora puedes acceder con tus datos.');
                return $this->redirect(['site/login']);
            }
        }

        return $this->render('recoverPassword', [
            'user' => $user,
        ]);
    }

    public function actionForgotPassword()
    {
        $this->layout = 'main';
        if (($email = Yii::$app->request->post('email')) && ($user = User::find()->where(['email' => $email])->one())) {
            $user->token = md5(sha1(time()).rand(1,999)).md5(date('D'));
            $user->token_fecha = date('Y-m-d H:i:s');
            if ($user->save()) {
                $user->sendRecoveryEmail($user);
                Yii::$app->session->setFlash('success-forgot-password', 'En breves instantes recibirás un correo con las instrucciones para recuperar tu contraseña.');
            } else {
                Yii::$app->session->setFlash('error-forgot-password', 'Ha habido un problema al enviar el correo de recuperación. Por favor, inténtalo de nuevo.');
            }
        } elseif (Yii::$app->request->post()) {
            Yii::$app->session->setFlash('error-forgot-password', 'La dirección de correo introducida no existe.');
        }
        return $this->render('forgotPassword');
    }





    public function actionIndex()
    {

        return $this->render('index', [/*//backend/index*/
            //'var'=>$var,
        ]);
    }




    public function actionAyuda()
    {

        return $this->render('ayuda', [/*//backend/index*/
            //'var'=>$var,
        ]);
    }


    
    public function actionInformes()
    {
        $terminales=Terminal::find()->all();
        return $this->render('informes', [/*//backend/index*/
            'terminales'=>$terminales
        ]);
    }


    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm;
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
