<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Terminal */

$this->title = \Yii::t('app', 'Nuevo terminal de pago');
$this->params['breadcrumbs'][] = ['label' => 'Terminals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="terminal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Atrás'), ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
