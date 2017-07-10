<?php

namespace app\controllers;

use Yii;
use app\model\MonederoHistorico;
use app\components\InttegrumController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Monedero;



/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class BackendController extends InttegrumController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function() {
                            return \Yii::$app->permiso->todosMenosUsuarios();
                        }
                    ]
                ]
            ]
        ];
    }


    public function actionEstadisticas()
    {
        $movimientos = (new \yii\db\Query())
            ->select(['count(id) as num','tipo_operacion'])
            ->from('monedero_historico')
            ->groupBy(['tipo_operacion'])
            ->all();

        $movimientos_este_mes = (new \yii\db\Query())
            ->select(['count(id) as num','tipo_operacion'])
            ->from('monedero_historico')
            ->groupBy(['tipo_operacion'])
            ->where('Year(fecha_hora) = Year(CURRENT_TIMESTAMP)')
            ->andwhere('Month(fecha_hora) = Month(CURRENT_TIMESTAMP)')
            ->all();

        $movimientos_por_meses_este_anyo = (new \yii\db\Query())
            ->select(['count(id) as num','Month(fecha_hora) as mes' ])
            ->from('monedero_historico')
            ->groupBy(['Month(fecha_hora)'])
            ->where('Year(fecha_hora) = Year(CURRENT_TIMESTAMP)')
            ->andwhere('tipo_operacion="Pago"')
            ->all();

        return $this->render('estadisticas', [/*//backend/index*/
            'movimientos'=>$movimientos,
            'movimientos_este_mes'=>$movimientos_este_mes,
            'movimientos_por_meses_este_anyo'=>$movimientos_por_meses_este_anyo,
        ]);
    }


    public function actionInformeMovimientos()
    {
        //Obtengo los galores del get
        $request = Yii::$app->request;
        $get = $request->get();
        //Busco todos los pagos que cumplan criterio
        $pagos = (new \yii\db\Query())
            ->select(['monedero_historico.fecha_hora','monedero_historico.tipo_operacion','monedero_historico.importe','monedero_historico.concepto','usuario.nombre','usuario.apellidos','terminal.nombre as t_nombre'])
            ->from('monedero_historico, monedero, usuario, terminal')
            ->where('DATE_FORMAT(fecha_hora,"%Y")=:anyo',
                    [':anyo' => $get['anyo']])
            ->andWhere('DATE_FORMAT(fecha_hora,"%m")=:mes',
                    [':mes' => $get['mes']])
            ->andWhere('monedero_historico.monedero_id=monedero.id')
            ->andWhere('usuario.id=monedero.usuario_id')
            ->andWhere('terminal.id=monedero_historico.terminal_id')
            ->all();

        $this->layout="printLayout";

        return $this->render('//informes/movimientos.php', [
            'pagos' => $pagos,
            'filtros'=>$get,
            'tipo_operacion'=>$tipo_operacion,
        ]);
    }

    public function actionInformePagos()
    {
        //Obtengo los galores del get
        $request = Yii::$app->request;
        $get = $request->get();
        //Busco todos los pagos que cumplan criterio
        $pagos = (new \yii\db\Query())
            ->select(['monedero_historico.fecha_hora','monedero_historico.tipo_operacion','monedero_historico.importe','monedero_historico.concepto','usuario.nombre','usuario.apellidos','terminal.nombre as t_nombre'])
            ->from('monedero_historico, monedero, usuario, terminal')
            ->where('DATE_FORMAT(fecha_hora,"%Y")=:anyo',
                    [':anyo' => $get['anyo']])
            ->andWhere('DATE_FORMAT(fecha_hora,"%m")=:mes',
                    [':mes' => $get['mes']])
            ->andWhere('monedero_historico.terminal_id=:terminal_id',
                    [':terminal_id' => $get['terminal_id']])
            ->andWhere('monedero_historico.monedero_id=monedero.id')
            ->andWhere('usuario.id=monedero.usuario_id')
            ->andWhere('terminal.id=monedero_historico.terminal_id')
            ->andWhere('monedero_historico.tipo_operacion="Pago"')
            ->all();

        $this->layout="printLayout";

        return $this->render('//informes/pagos.php', [
            'pagos' => $pagos,
            'filtros'=>$get,
            'tipo_operacion'=>$tipo_operacion,
        ]);
    }

    public function actionInformeDevoluciones()
    {
        //Obtengo los galores del get
        $request = Yii::$app->request;
        $get = $request->get();
        //Busco todos los pagos que cumplan criterio
        $pagos = (new \yii\db\Query())
            ->select(['monedero_historico.fecha_hora','monedero_historico.tipo_operacion','monedero_historico.importe','monedero_historico.concepto','usuario.nombre','usuario.apellidos','terminal.nombre as t_nombre'])
            ->from('monedero_historico, monedero, usuario, terminal')
            ->where('DATE_FORMAT(fecha_hora,"%Y")=:anyo',
                    [':anyo' => $get['anyo']])
            ->andWhere('DATE_FORMAT(fecha_hora,"%m")=:mes',
                    [':mes' => $get['mes']])
            ->andWhere('monedero_historico.monedero_id=monedero.id')
            ->andWhere('usuario.id=monedero.usuario_id')
            ->andWhere('terminal.id=monedero_historico.terminal_id')
            ->andWhere('monedero_historico.tipo_operacion="Devolución"')
            ->all();

        $this->layout="printLayout";

        return $this->render('//informes/devoluciones.php', [
            'pagos' => $pagos,
            'filtros'=>$get,
            'tipo_operacion'=>$tipo_operacion,
        ]);
    }
    public function actionInformeAnulaciones()
    {
        //Obtengo los galores del get
        $request = Yii::$app->request;
        $get = $request->get();
        //Busco todos los pagos que cumplan criterio
        $pagos = (new \yii\db\Query())
            ->select(['monedero_historico.fecha_hora','monedero_historico.tipo_operacion','monedero_historico.importe','monedero_historico.concepto','usuario.nombre','usuario.apellidos','terminal.nombre as t_nombre'])
            ->from('monedero_historico, monedero, usuario, terminal')
            ->where('DATE_FORMAT(fecha_hora,"%Y")=:anyo',
                    [':anyo' => $get['anyo']])
            ->andWhere('DATE_FORMAT(fecha_hora,"%m")=:mes',
                    [':mes' => $get['mes']])
            ->andWhere('monedero_historico.monedero_id=monedero.id')
            ->andWhere('usuario.id=monedero.usuario_id')
            ->andWhere('terminal.id=monedero_historico.terminal_id')
            ->andWhere('monedero_historico.tipo_operacion="Anulación"')
            ->all();

        $this->layout="printLayout";

        return $this->render('//informes/anulaciones.php', [
            'pagos' => $pagos,
            'filtros'=>$get,
            'tipo_operacion'=>$tipo_operacion,
        ]);
    }



    public function actionTerminalVentasFijacionPrecio($terminal_id)//TerminalVentasFijacionPrecio
    {
        $this->layout="printLayout";

        return $this->render('terminal-ventas-fijacion-precio.php', [
            'terminal_id'=>$terminal_id,
        ]);
    }



    public function actionTerminalVentasMenuTerminal($terminal_id)//TerminalVentasFijacionPrecio
    {
        $this->layout="printLayout";

        return $this->render('terminal-ventas-menu-terminal.php', [
            'terminal_id'=>$terminal_id,
        ]);
    }




    public function actionTerminalVentasLecturaRfid($dinero,$terminal_id)//TerminalVentasFijacionPrecio
    {
        $this->layout="printLayout";

        return $this->render('terminal-ventas-lectura-rfid.php', [
            'dinero'=>$dinero,
            'terminal_id'=>$terminal_id,
        ]);
    }


}
