<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MonederoHistorico */

$this->title = \Yii::t('app', 'Editar Monedero Historico');
$this->params['breadcrumbs'][] = ['label' => 'Monedero Historicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="monedero-historico-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?= Html::a(Yii::t('app', 'Atrás'), ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
