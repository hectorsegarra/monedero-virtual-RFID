<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\Permiso;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Detalles del usuario');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
            //'id',
            'nombre',
            'apellidos',
            'email:email',
            //'password',
            [
                'attribute' => 'nivel',
                'value' => Permiso::getNombreNivel($model->nivel)
            ],
            'tag_rfid',
            'estado',
        ],
    ]) ?>

</div>
