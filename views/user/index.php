<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\UserAltaBaja;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Search\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', Yii::t('app', 'Gestión de usuarios'));
$this->params['breadcrumbs'][] = $this->title;

/**
 * JavaScript para ocultar alertas después de 5 segundos o al hacer click
 */
$js = 'setTimeout(function() {
            $(".alert").fadeOut(500);
        }, 3000);';
$this->registerJs($js);


$urlBaja = yii\helpers\Url::toRoute(['user-alta-baja/dar-de-baja']);
$textoBaja = \Yii::t('app', '¿Desea dar de baja a este usuario?');
$jsDarDeBaja = <<<EOD
    //$(".dar-de-baja").click(function() {
    $(document).on("click", ".dar-de-baja", function() {
        $.ajax({
            type: 'POST',
            data: {id: $(this).attr("data-usuario-id")},
            cache: false,
            url: "$urlBaja",
            beforeSend: function() {
            var confirmacion = confirm("$textoBaja");
                if (confirmacion === true) {
                    return true;
                } else {
                    return false;
                }
            },
            success: function(response) {
                $.pjax.reload({container:'#reload'});
                //location.reload();
            }
        });
    });
EOD;
$this->registerJs($jsDarDeBaja);

$urlAlta = yii\helpers\Url::toRoute(['user-alta-baja/dar-de-alta']);
$textoAlta = \Yii::t('app', '¿Desea dar de alta a este usuario?');
$jsDarDeAlta = <<<EOD
    //$(".dar-de-alta").click(function() {
    $(document).on("click", ".dar-de-alta", function() {
        $.ajax({
            type: 'POST',
            data: {id: $(this).attr("data-usuario-id")},
            cache: false,
            url: "$urlAlta",
            beforeSend: function() {
            var confirmacion = confirm("$textoAlta");
                if (confirmacion === true) {
                    return true;
                } else {
                    return false;
                }
            },
            success: function(response) {
                $.pjax.reload({container:'#reload'});
                //location.reload();
            }
        });
    });
EOD;
$this->registerJs($jsDarDeAlta);
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a(Yii::t('app', 'Crear usuario'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php if (\Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <div class="col-md-4" style="margin-right:0px;float:right;">
        <?php
        $pageSizeOptions = array(50 => '50', 100 => '100', 200 => '200', 500 => '500');
        echo Html::dropDownList('per-page', isset($_GET['per-page']) ? $_GET['per-page'] : $dataProvider->pagination->pageSize, $pageSizeOptions, array(
            'class' => 'form-control',
            'id' => 'dropdown-pagesize',
        ));
        ?>
    </div>

    <div style="clear:both"></div>
    <?php \yii\widgets\Pjax::begin(['id' => 'reload', 'timeout' => 3000]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterSelector' => '[name="per-page"]',
        'layout' => "{summary}\n{items}\n{pager}",
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed'],
        'pager' => [
            'lastPageLabel' => 'Última página',
            'firstPageLabel' => 'Primera página',
        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            ///'id',
            [
                'attribute' => 'nombreCompleto',
                'header' => 'Nombre completo',
                'value' => function($model) {
                    return $model->nombre . ' ' . $model->apellidos;
                }
            ],
            //'nombre',
            //'apellidos',
            'email:email',
            'dni',
            'tag_rfid',
            /* [
              'attribute' => 'estado',
              //'value' => app\models\UserAltaBaja::getButtonEstado($model->userAltaBajas[0])
              'value' => function($model) {
              $a = $model->userAltaBajas;
              return UserAltaBaja::getButtonEstado(end($a)->tipo, $model->id);
              },
              'format' => 'raw'
              ], */
            //'password',
            // 'nivel',
            // 'tag_rfid',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {password}',
                'buttons' => [
                    'update' => function($url, $model) {
                        return Html::a(
                                Html::button('Ver ficha', ['class' => 'btn btn-default btn-xs']), yii\helpers\Url::toRoute(['update', 'id' => $model->id]), [
                                'title' => \Yii::t('yii', 'Ver ficha'),
                                'data-pjax' => '0',
                                ]
                        );
                    },
                        'password' => function($url, $model) {
                        return Html::a(
                                Html::button('Editar contraseña', ['class' => 'btn btn-default btn-xs']), yii\helpers\Url::toRoute(['update-password', 'id' => $model->id]), [
                                'title' => \Yii::t('yii', 'Editar contraseña'),
                                'data-pjax' => '0',
                                ]
                        );
                    },
                        'altas' => function($url, $model) {
                        return Html::a(
                                Html::button('Altas y bajas', ['class' => 'btn btn-default btn-xs']), yii\helpers\Url::toRoute(['/user-alta-baja/index', 'id' => $model->id]), [
                                'title' => \Yii::t('yii', 'Historial de altas y bajas'),
                                'data-pjax' => '0',
                                ]
                        );
                    },
                        'cuotas' => function($url, $model) {
                        return Html::a(
                                '<span class="fa fa-eur"></span>', yii\helpers\Url::toRoute(['/cuota-user/index', 'id' => $model->id]), [
                                'title' => \Yii::t('yii', 'Cuotas del usuario'),
                                'data-pjax' => '0',
                                ]
                        );
                    },
                        'accesos' => function($url, $model) {
                        return Html::a(
                                '<span class="fa fa-minus-circle"></span>', yii\helpers\Url::toRoute(['/user-espacio-permiso/index', 'id' => $model->id]), [
                                'title' => \Yii::t('yii', 'Accesos del usuario'),
                                'data-pjax' => '0',
                                ]
                        );
                    },
                        'incidencias' => function($url, $model) {
                        return Html::a(
                                '<span class="fa fa-flag"></span>', yii\helpers\Url::toRoute(['/user-espacio-historico/index', 'id' => $model->id]), [
                                'title' => \Yii::t('yii', 'Incidencias del usuario'),
                                'data-pjax' => '0',
                                ]
                        );
                    },
                        'borrar' => function($url, $model) {
                        return Html::a(
                                Html::button('Borrar', ['class' => 'btn btn-danger btn-xs']), '#', [
                                'title' => \Yii::t('yii', 'Borrar'),
                                'data-pjax' => '1',
                                'onclick' =>
                                "$.ajax({
                                        type: 'POST',
                                        data: {id: " . $model->id . "},
                                        cache: false,
                                        url: '" . yii\helpers\Url::toRoute(['delete', 'id' => $model->id]) . "',
                                        beforeSend: function() {
                                        var confirmation = confirm('" . \Yii::t('app', '¿Desea borrar este elemento?') . "');
                                            if (confirmation === true) {
                                                return true;
                                            } else {
                                                return false;
                                            }
                                        },
                                        success: function(response) {
                                            $.pjax.reload({container:'#reload'});
                                        },
                                        error: function(response) {
                                            alert(response.responseText);
                                        }
                                    }); return false;"
                                ]
                        );
                    },
                    ]
                ],
            ],
        ]);
        ?>
        <?php \yii\widgets\Pjax::end();?>
</div>
