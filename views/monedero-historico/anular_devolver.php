<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MonederoHistorico */
$operacion_correctaMAY="";
$operacion_correctaMIN="";
$boton_title="";
$texto_concepto="";

if ($operacion=='anulacion'){
    $operacion_correctaMAY="Anulación";
    $operacion_correctaMIN="anulación";
    $boton_title="Anular operación";
    $texto_concepto="Anula al movimiento: ";
}else if($operacion='devolucion'){
    $operacion_correctaMAY="Devolución";
    $operacion_correctaMIN="devolucion";
    $boton_title="Emitir devolución";
    $texto_concepto="Devolucion emitida para el movimiento: ";
}

$this->title = \Yii::t('app', "Crear $operacion_correctaMIN");
$this->params['breadcrumbs'][] = ['label' => 'Monedero Historicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="monedero-historico-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Atrás'), ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <div><strong>Monedero de: </strong><?=$model->monedero->usuario->FullName?></div>

    <div><strong>Realizado en la terminal: </strong><?=$model->terminal->nombre?></div>

    <div><strong>Fecha de la operación: </strong><?=$model->fecha_hora?></div>

    <div><strong>Tipo de operación: </strong><?=$model->tipo_operacion?></div>

    <div><strong>Importe: </strong><?=$model->importe?></div>

    <div><strong>Concepto: </strong><?=$model->concepto?></div>

    <div class="monedero-historico-form">

        <?php $form = ActiveForm::begin(); ?>
        <?php
            //Se clonan
             echo $form->field($model, 'monedero_id')->hiddenInput()->label(false);
            //se modifican
             echo $form->field($model, 'terminal_id')->hiddenInput(['value'=> $terminal_id])->label(false);
             echo $form->field($model, 'tipo_operacion')->hiddenInput(['value'=>$operacion_correctaMAY])->label(false);
             echo $form->field($model, 'concepto')->hiddenInput(['value'=> $texto_concepto.$model->id])->label(false);
             echo $form->field($model, 'importe')->hiddenInput(['value'=> -1*$model->importe])->label(false);
         ?>
        <div class="row">
            <div class="col-md-4">
                <?= Html::submitButton(\Yii::t('app', $boton_title), ['class' =>  'btn btn-success' ]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>



</div>
