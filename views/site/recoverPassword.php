<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = \Yii::t('app', 'Recuperar contraseña');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-password-recovery">
    <div class="row cuadroBusquedas">
    <?php $form = ActiveForm::begin([
        'id' => 'recovery-form',
    ]); ?>
    
    <div class="row">
        <div class="col-md-4">   
            <?= $form->field($user, 'formPassword')->passwordInput(['maxlength' => 100]) ?>
        </div>
        <div class="col-md-4">   
            <?= $form->field($user, 'formPasswordRepeat')->passwordInput(['maxlength' => 100]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= Html::submitButton(\Yii::t('app', 'Cambiar contraseña'), ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="col-md-4">
            <?= Html::a('Entrar con mi cuenta', ['site/login']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>

