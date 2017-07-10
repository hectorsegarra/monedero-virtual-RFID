<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\components\InttegrumHelpers;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Yii 2 Inttegrum - Contacto';
$this->params['breadcrumbs'][] = $this->title;

?>
<div  class="row">
    <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
        <h2>texto</h2>
        <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?= \Yii::t('app', 'Gracias por contactar con nosotros. Le responderemos lo antes posible.'); ?>
            </div>
        <?php endif; ?>
        <div class="container-fluid">

            <?php $form = ActiveForm::begin([
                'id' => 'contact-form',
                'layout' => 'horizontal',
                'action' => \yii\helpers\Url::to(['site/contacto']),
                'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-2',
                        'offset' => 'col-sm-offset-4',
                        'wrapper' => 'col-sm-10',
                        'error' => '',
                        'hint' => '',
                    ],
                ],
            ]); ?>

            <div class="form-group">
                <div class="col-sm-12 col-lg-12">
                    <?= $form->field($model, 'nombre') ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <?= $form->field($model, 'email') ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <?= $form->field($model, 'telefono') ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <?= $form->field($model, 'asunto') ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <?= $form->field($model, 'mensaje')->textarea(['rows'=>6]) ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12 col-lg-12">
                    <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-4">{image}<i class="fa fa-refresh fa-lg"></i></div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <?= Html::submitButton(\Yii::t('app', 'Enviar mensaje'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <div style="clear:both;"></div>
        </div>
    </div><!-- /.col-md-12  -->
</div>