<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Monedero */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="monedero-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">
        <div class="col-md-4">   
            <?= $form->field($model, 'usuario_id')->input('number', ['min'=>0, 'step'=>1]) ?>
        </div>
    </div>
	<div class="row">
        <div class="col-md-4">   
            <?= $form->field($model, 'cantidad')->input('number', ['min'=>0, 'step'=>1]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Crear') : \Yii::t('app', 'Editar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

