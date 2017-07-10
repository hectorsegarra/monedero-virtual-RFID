<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = \Yii::t('app', 'Cambiar contraseña');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pass-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?= Html::a(Yii::t('app', 'Atrás'), ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
    
    <div class="pass-form">

        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-4">   
                <?= $form->field($model, 'formPassword')->passwordInput(['maxlength' => 256]) ?>
            </div>
            <div class="col-md-4">   
                <?= $form->field($model, 'formPasswordRepeat')->passwordInput(['maxlength' => 256]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Crear') : \Yii::t('app', 'Editar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
