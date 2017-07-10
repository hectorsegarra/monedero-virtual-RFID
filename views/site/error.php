<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <p>
        <?= \Yii::t('app', 'Por favor, contacte con nosotros si cree que esto es un error. Gracias.') ?>
    </p>

</div>
