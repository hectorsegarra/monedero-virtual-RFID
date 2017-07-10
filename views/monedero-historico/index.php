<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MonederoHistoricoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', 'Historico de movimientos');
$this->params['breadcrumbs'][] = $this->title;

/**
 * JavaScript para ocultar alertas después de 5 segundos o al hacer click
 */
$js =   'setTimeout(function() {
            $(".alert").fadeOut(500);
        }, 3000);';
$this->registerJs($js);
?>
<div class="monedero-historico-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if (\Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <div class="col-md-4" style="margin-right:0px;float:right;">
    <?php
        $pageSizeOptions = array(20 => '20', 50 => '50', 100 => '100', 200 => '200');
        echo Html::dropDownList('per-page', isset($_GET['per-page']) ? $_GET['per-page'] : '', $pageSizeOptions, array(
            'class' => 'form-control',
            'id' => 'dropdown-pagesize',
            ));
    ?>
    </div>

    <div style="clear:both"></div>
    <?php \yii\widgets\Pjax::begin(['id'=>'reload']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterSelector' => '[name="per-page"]',
        'layout' => "{summary}\n{items}\n{pager}",
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fecha_hora',
            'monedero_id',
            'terminal_id',
            'tipo_operacion',
             'importe',
             'concepto',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {anular} {devolver}',
                'buttons' => [
                    'update' => function($url, $model) {
                        return Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>',
                                yii\helpers\Url::toRoute(['//monedero-historico/update', 'id' => $model->id]),
                                [
                                    'title'=>\Yii::t('yii', 'Editar'),
                                    'data-pjax' => '0',
                                ]
                            );
                    },
                    'anular' => function($url, $model) {
                        return Html::a(
                                'Anular',
                                yii\helpers\Url::toRoute(['//monedero-historico/anular-devolver', 'id' => $model->id,'operacion'=>'anulacion']),
                                [
                                    'title'=>\Yii::t('yii', 'Anular'),
                                    'data-pjax' => '0',
                                ]
                            );
                    },
                    'devolver' => function($url, $model) {
                        return Html::a(
                                'Devolver',
                                yii\helpers\Url::toRoute(['//monedero-historico/anular-devolver', 'id' => $model->id,'operacion'=>'devolucion']),
                                [
                                    'title'=>\Yii::t('yii', 'Devolver'),
                                    'data-pjax' => '0',
                                ]
                            );
                    },

                ]
            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
