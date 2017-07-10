<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = \Yii::t('app', 'Recuperación de contraseña');
$this->params['breadcrumbs'][] = $this->title;
?>
    
<div class="site-login">
    
    <div class="row">
        <div class="col-md-12">
    <?php if (\Yii::$app->session->hasFlash('success-forgot-password')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('success-forgot-password') ?>
        </div>
    <?php elseif (\Yii::$app->session->hasFlash('error-forgot-password')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('error-forgot-password') ?>
        </div>
    <?php endif; ?>
        </div>
    </div>
    
    <div class="row cuadroBusquedas">
    <?php $form = ActiveForm::begin([
        'id' => 'forgot-password-form',
        'fieldConfig' => [
        ],
    ]); ?>
    
        <div class="row">
            <div class="col-md-4">
                <?= Html::label('Correo electrónico', 'email') ?>
                <?= Html::textInput('email', '', ['required' => true, 'class' => 'form-control']) ?>
            </div>
        </div>

        <div style="margin-top: 15px;" class="row">
            <div class="col-md-4">
                <?= Html::submitButton(\Yii::t('app', 'Recuperar contraseña'), ['class' => 'btn btn-primary']) ?>
            </div>
            <div class="col-md-4">
                <?= Html::a('Entrar con mi cuenta', ['site/login']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>