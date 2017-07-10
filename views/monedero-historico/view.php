<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MonederoHistorico */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Monedero Historicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monedero-historico-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(\Yii::t('app', 'Atrás'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(\Yii::t('app', 'Editar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(\Yii::t('app', 'Borrar'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => \Yii::t('app','¿Desea borrar este elemento?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'monedero_id',
            'terminal_id',
            'fecha_hora',
            'tipo_operacion',
            'importe',
            'concepto',
        ],
    ]) ?>

</div>
