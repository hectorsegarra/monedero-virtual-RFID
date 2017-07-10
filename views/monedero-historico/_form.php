<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MonederoHistorico */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="monedero-historico-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'monedero_id')->input('number', ['min'=>0, 'step'=>1]) ?>
        </div>
    </div>
	<div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'terminal_id')->input('number', ['min'=>0, 'step'=>1]) ?>
        </div>
    </div>
	<div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'fecha_hora')->textInput() ?>
        </div>
    </div>
	<div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'tipo_operacion')->textInput(['maxlength' => 50]) ?>
        </div>
    </div>
	<div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'importe')->textInput(['min'=>0, 'step'=>1]) ?>
        </div>
    </div>
	<div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'concepto')->textInput(['maxlength' => 150]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Crear') : \Yii::t('app', 'Editar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
