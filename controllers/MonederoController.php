<?php

namespace app\controllers;

use Yii;
use app\models\Monedero;
use app\models\search\MonederoSearch;
use app\models\User;
use app\components\InttegrumController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\MonederoHistorico;

/**
 * MonederoController implements the CRUD actions for Monedero model.
 */
class MonederoController extends InttegrumController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function() {
                            return \Yii::$app->permiso->isAdmin();
                        }
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Monedero models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MonederoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Monedero model.
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
     * Creates a new Monedero model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Monedero();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'El registro se ha creado correctamente'), true);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Monedero model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'El registro se ha actualizado correctamente'), true);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }




    /**
     * inserta o retira saldo del monedero de un usuario.
     * @param integer $id
     * @return mixed
     */
    public function actionModificarsaldo()
    {
        if (!Yii::$app->request->post('cantidad') || !Yii::$app->request->post('monedero_id')) {
            throw new \yii\web\HttpException(400, 'Bad request');
        }
        /*Obtenemos los valores*/
        $monedero_id=Yii::$app->request->post('monedero_id');
        $cantidad=Yii::$app->request->post('cantidad');
        $tipo_operacion=Yii::$app->request->post('tipo_operacion');
        /*Buscamos el monedero a modificar*/
        $model = $this->findModel($monedero_id);
        /*Modificamos del modelo el campo cantidad*/
        $model->cantidad=$model->cantidad+$cantidad;

        /*creamos un nuevo movimiento con los datos de esta odificacion*/
        $model_historico = new MonederoHistorico();
        $model_historico->monedero_id = $monedero_id;
        $model_historico->terminal_id = 1;
        $model_historico->tipo_operacion = $tipo_operacion;
        $model_historico->importe = $cantidad;
        $model_historico->concepto = $tipo_operacion;
        //$tipo_operacion

        /*Guardamos los cambios*/
        $transaction = Yii::$app->db->beginTransaction();
        if ($model->save()) {
            if ($model_historico->save()) {
                $transaction->commit();
                return $model->cantidad;
            }else{
                $transaction->rollBack();
                return 2; //Error al guardar en historico
            }
        } else {
            $transaction->rollBack();
            return 0; //Error alguardar el monedero
        }
    }










    public function actionRealizarPago(){
        if (!Yii::$app->request->post('rfid')) {
             throw new \yii\web\HttpException(500, 'Error 1, no hay post');
        }
        //Asignamos la cantidad a pagar
        $cantidad=Yii::$app->request->post('cantidad');
        $terminal_id=Yii::$app->request->post('terminal_id');

        $cantidad=$cantidad*-1;
        //Buscamos al usuario
        $usuario = User::find()
            ->where('tag_rfid = :post', [':post' => Yii::$app->request->post('rfid')])
            ->asArray()
            ->one();
        if (!$usuario) {
             throw new \yii\web\HttpException(500, 'No se ha encontrado un usuario registrado con este RFID');
        }
        //Buscamos el monedero de su usuario

        $monedero = Monedero::find()
            ->where('usuario_id = :post2', [':post2' => $usuario['id']])->one();
            //->asArray()
            //->one();
        if (!$monedero) {
             throw new \yii\web\HttpException(500, 'El usuario de este RFID no dispone de monedero virtual');
        }
        //USUARIO Y MONEDERO ENCONTRADOS
        /*Modificamos del modelo el campo cantidad*/
        $monedero->cantidad=$monedero->cantidad+$cantidad;

        /*creamos un nuevo movimiento con los datos de esta odificacion*/
        $model_historico = new MonederoHistorico();
        $model_historico->monedero_id = $monedero->id;
        $model_historico->terminal_id = $terminal_id;
        $model_historico->tipo_operacion = "Pago";
        $model_historico->importe = $cantidad;
        $model_historico->concepto = "Pago en terminal";
        //$tipo_operacion

        /*Guardamos los cambios*/
        $transaction = Yii::$app->db->beginTransaction();
        if ($monedero->save()) {
            if ($model_historico->save()) {
                $transaction->commit();
                return $monedero->cantidad;
            }else{
                $transaction->rollBack();
                throw new \yii\web\HttpException(500, 'Error al guardar en el hisotrico de movimientos'); //Error al guardar en historico
            }
        } else {
            $transaction->rollBack();
            throw new \yii\web\HttpException(500, 'Error al modificar el monedero del usuario'); //Error alguardar el monedero
        }





        //return $monedero->cantidad;

    }












    /**
     * Deletes an existing Monedero model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->request->isAjax) {
            echo $this->findModel($id)->delete();
        } else {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Monedero model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Monedero the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Monedero::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página requerida no existe.');
        }
    }
}
