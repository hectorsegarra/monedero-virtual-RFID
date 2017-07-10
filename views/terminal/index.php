<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TerminalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Terminales de pago');
$this->params['breadcrumbs'][] = $this->title;

/**
 * JavaScript para ocultar alertas después de 5 segundos o al hacer click
 */
$js =   'setTimeout(function() {
            $(".alert").fadeOut(500);
        }, 3000);';
$this->registerJs($js);
?>
<div class="terminal-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Terminal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
            'nombre',
            'descripcion',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'update' => function($url, $model) {
                        return Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>',
                                yii\helpers\Url::toRoute(['update', 'id' => $model->id]),
                                [
                                    'title'=>\Yii::t('yii', 'Editar'),
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
