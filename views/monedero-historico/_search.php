<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\MonederoHistoricoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="monedero-historico-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'monedero_id') ?>

    <?= $form->field($model, 'terminal_id') ?>

    <?= $form->field($model, 'fecha_hora') ?>

    <?= $form->field($model, 'tipo_operacion') ?>

    <?php // echo $form->field($model, 'importe') ?>

    <?php // echo $form->field($model, 'concepto') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
