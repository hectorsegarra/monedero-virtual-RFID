<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = \Yii::t('app', 'Iniciar sesión');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row cuadroBusquedas">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'fieldConfig' => [
        ],
    ]); ?>

    
    <div class="row">
        <div class="col-md-4">  
            <?= $form->field($model, 'username') ?>
        </div>
        <div class="col-md-4"> 
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4"> 
            <?php echo $form->field($model, 'rememberMe', [])->checkbox() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= Html::submitButton(\Yii::t('app', 'Iniciar sesión'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
        <div class="col-md-4">
            <?= Html::a('Recuperar contraseña', ['site/forgot-password']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>