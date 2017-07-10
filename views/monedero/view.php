<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Monedero */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Monederos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monedero-view">

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
            'usuario_id',
            'cantidad',
        ],
    ]) ?>

</div>
