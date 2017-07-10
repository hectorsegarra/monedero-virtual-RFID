<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Terminal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="terminal-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => 20]) ?>
        </div>

        <div class="col-md-8">   
            <?= $form->field($model, 'descripcion')->textInput(['maxlength' => 250]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Crear') : \Yii::t('app', 'Editar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
