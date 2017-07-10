<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\User */


$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

    <p>
        <?= Html::a(Yii::t('app', 'Atrás'), ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <h2>Ficha de <span style="color:blue;"><?=$model->nombre.' '.$model->apellidos?></span></h2>

    <p style="font-size:16px;"><strong>Saldo del monedero: <span style="color:<?=($model_monedero->cantidad>=0)?'#6AC45A':'red';?>"><?=$model_monedero->cantidad?></span></strong></p>



    <?php if (\Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible hide-3s" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>



    <?php if (\Yii::$app->session->hasFlash('yaTieneCuota')): ?>
        <div class="alert alert-danger alert-dismissible hide-10s" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('yaTieneCuota') ?>
        </div>
    <?php endif; ?>

    <?php if (\Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible hide-10s" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php
    //Primero se meten las pestañas una a una en el array para tener el control y luego se le pasa el array al widget
    //$items = [];
    $items = [[
                'label' => 'Datos',
                'content' => $this->render('_formUpdate', ['model' => $model]),
                'active' => true
            ],
            [
                'label' => 'Movimientos',
                'content' => $this->render('//monedero-historico/index', ['searchModel' => $searchModel,'dataProvider' => $dataProvider,]),
                //'visible' => $model->nivel_permisos != 0
            ]];

    echo yii\bootstrap\Tabs::widget([
        'items' => $items
    ]);

    /*echo yii\bootstrap\Tabs::widget([
        'items' => [
            [
                'label' => 'Datos',
                'content' => $this->render('_formUpdate', ['model' => $model]),
                'active' => true
            ],
            [
                'label' => 'Empresas',
                'content' => $this->render('_empresas', ['empresas' => $empresas, 'usuarioEmpresas' => $usuarioEmpresas, 'model' => $model]),
                'visible' => $model->nivel_permisos != 0
            ],
            [
                'label' => 'Cuotas',
                'content' => $this->render('//cuota-user/_index', $dataCuotas),
            ],
            [
                'label' => 'Pagos',
                'content' => $this->render('//cuota-user-historico/_pagos', array_merge($dataCuotas, $dataPagos)),
            ],
            [
                'label' => 'Acceso especial',
                'content' => $this->render('//user-espacio-permiso/index', $datosAccesoEspecial),
            ],
            [
                'label' => 'Reservas',
                'content' => '',
            ],
            [
                'label' => 'Incidencias',
                'content' => '',
            ],
        ],
    ]);*/
    ?>

</div>
