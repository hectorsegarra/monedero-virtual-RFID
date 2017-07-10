<?php

namespace app\controllers;

use Yii;
use app\models\MonederoHistorico;
use app\models\User;
use app\models\Monedero;
use app\models\search\MonederoHistoricoSearch;
use app\components\InttegrumController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MonederoHistoricoController implements the CRUD actions for MonederoHistorico model.
 */
class MonederoHistoricoController extends InttegrumController
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
     * Lists all MonederoHistorico models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MonederoHistoricoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->setSort(['defaultOrder' => [ 'id' => SORT_DESC],]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tipo' => 'movimientos',
        ]);
    }

    /**
     * Lists all MonederoHistorico models Filtered by "tipo_operacion=Anulacion".
     * @return mixed
     */
    public function actionIndexAnulacion()
    {
        $searchModel = new MonederoHistoricoSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->setSort(['defaultOrder' => [ 'id' => SORT_DESC],]);

        /*Set filter tipo_operacion = 'Anulacion'*/
        $dataProvider->query->andFilterWhere(['tipo_operacion'=>'Anulacion']);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tipo' => 'anulaciones',
        ]);
    }

    /**
     * Lists all MonederoHistorico models Filtered by "tipo_operacion=Devolucion".
     * @return mixed
     */
    public function actionIndexDevolucion()
    {
        $searchModel = new MonederoHistoricoSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->setSort(['defaultOrder' => [ 'id' => SORT_DESC],]);

        /*Set filter tipo_operacion = 'Anulacion'*/
        $dataProvider->query->andFilterWhere(['tipo_operacion'=>'Devolucion']);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tipo' => 'devoluciones',
        ]);
    }

    /**
     * Displays a single MonederoHistorico model.
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
     * Creates a new MonederoHistorico model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MonederoHistorico();

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
     * Updates an existing MonederoHistorico model.
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
     * Updates an existing MonederoHistorico model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAnularDevolver($id,$operacion,$terminal_id=1)
    {
        $model = new MonederoHistorico();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $monedero = Monedero::findOne($model->monedero_id);
            $monedero->cantidad=$monedero->cantidad+$model->importe;
            $monedero->save();

            \Yii::$app->session->setFlash('success', \Yii::t('app', 'El registro se ha anulado correctamente'), true);
            return $this->redirect(['//user/upadate?id='.$monedero->usuario_id]);
        } else {
            $model = $this->findModel($id);
            return $this->render('anular_devolver', [
                'model' => $model,
                'terminal_id' =>$terminal_id,
                'operacion' => $operacion,
            ]);
        }
    }


    /**
     * Deletes an existing MonederoHistorico model.
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
     * Finds the MonederoHistorico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MonederoHistorico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MonederoHistorico::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página requerida no existe.');
        }
    }
}
