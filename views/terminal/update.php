<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Terminal */

$this->title = \Yii::t('app', 'Editar Terminal de pago');
$this->params['breadcrumbs'][] = ['label' => 'Terminals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="terminal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Atrás'), ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
