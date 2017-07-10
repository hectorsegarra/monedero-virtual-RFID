<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Monedero;
use app\models\search\UserSearch;
use app\models\MonederoHistorico;
use app\models\search\MonederoHistoricoSearch;
use app\components\InttegrumController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends InttegrumController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    //'get-users-selectize' => ['ajax'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function() {
                            return \Yii::$app->permiso->todosMenosUsuarios();
                            //return true;
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update-password'],
                        'matchCallback' => function() {
                            return \Yii::$app->permiso->todosMenosUsuarios();
                        }
                    ],
                ]
            ]
        ];
    }











    public function actionFindByRfid()
    {
        if (!Yii::$app->request->post('rfid')) {
            throw new \yii\web\HttpException(400, 'Bad request');
        }
        //Buscamos al usuario
        $usuario = User::find()
            ->where('tag_rfid = :post', [':post' => Yii::$app->request->post('rfid')])
            ->asArray()
            ->one();

        if (!$usuario) {
            throw new \yii\web\HttpException(500, 'Error');
        }
        //Buscamos el monedero de su usuario
        $monedero = Monedero::find()
            ->where('usuario_id = :post2', [':post2' => $usuario['id']])
            ->asArray()
            ->one();


        echo Json::encode([
            'nombre' => $usuario['nombre'].' '.$usuario['apellidos'],
            'dni' => $usuario['dni'],
            'email' => $usuario['email'],
            'id' => $usuario['id'],
            'monederoid' => $monedero['id'],
            'moneder_cantidad' => $monedero['cantidad'],
        ]);
    }












    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->nivel_permisos = 0;

        $transaction = Yii::$app->db->beginTransaction();

        if ($model->load(Yii::$app->request->post())) {


            if (!$model->save()) {
                $transaction->rollBack();
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Ha habido un error guardando el usuario, por favor, inténtelo de nuevo.'), true);
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

            /*

            if (isset($model->sendPassword) && isset($model->email)&&$model->sendPassword!='' && $model->email!=''){
                Yii::$app->mail->compose()
                        ->setFrom(['noresponder@InstalacionDeportiva.com' => 'Instalación deportiva'])
                        ->setTo([$model->email => $model->nombre.' '.$model->apellidos])
                        ->setSubject('Nueva alta en instalación deportiva')
                        //->setHtmlBody('Has sido dado de alta. En un futuro podrás acceder con tu correo y la contraseña '.$model->sendPassword.' para realizar reservas online.')
                        ->setTextBody('Bienvenido/a nuestras instalaciones '.$model->nombre.'.<br/><br/>
                                        Has sido dado/a de alta en nuestra base de datos de la instalación deportiva, en un futuro podras acceder a las reservas, a los bonos y demás con tu correo electronico y la contraseña:'.$model->sendPassword.' <br/><br/>
                                        Un saludo y muchas gracias.')
                        ->send();
            }
            */




            /*Creamos un nuevo monedero para este clientEvents*/
            $modelo_monedero = new Monedero();
            $modelo_monedero->usuario_id=$model->id;
            $modelo_monedero->cantidad=0;
            if (!$modelo_monedero->save()){
                $transaction->rollBack();
                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Ha habido un error creando un monedero para el usuario, por favor, inténtelo de nuevo.'), true);
                return $this->render('create', [
                    'model' => $model,
                ]);


            }

            //Solo se hace comit si todo sale ok
            $transaction->commit();

            \Yii::$app->session->setFlash('success', \Yii::t('app', 'El registro se ha creado correctamente'), true);
            return $this->redirect(['index']);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdatePassword($id)
    {
        $model = $this->findModel($id);
        User::checkUserUpdatePassword($model->id);

        //$model->scenario = 'update-password';

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', \Yii::t('app', 'La contraseña se ha actualizado correctamente'), true);
                return $this->redirect(['index']);
            } else {
                return $this->render('updatePassword', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('updatePassword', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //Seleccionar monedero del usuario
        $model_monedero=Monedero::find()->where(['usuario_id' => $id])->one();

        /*Seleccionar los movimientos de un usuario*/
        $searchModel = new MonederoHistoricoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['monedero_id'=>$model_monedero->id]);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'El registro se ha actualizado correctamente'), true);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model_monedero' => $model_monedero,
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
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
        try {
            if (Yii::$app->request->isAjax) {
                $model->delete();

            } else {
                $model->delete();

                return $this->redirect(['index', 'id' => $model->user_id]);
            }
        } catch (yii\db\IntegrityException $e) {
            //return $e->getMessage();
            if ($e->errorInfo[1] == 1451) {
                header('HTTP/1.1 500 Internal Server Error');
                die('No se puede borrar porque existen datos relacionados');
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                die('Ha habido un error. Inténtelo de nuevo');
            }
        }
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
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página requerida no existe.');
        }
    }
}
