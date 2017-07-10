<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MonederoHistorico */

$this->title = \Yii::t('app', 'Crear {modelClass}', ['modelClass' => \Yii::t('app', 'app\models\MonederoHistorico')]);
$this->params['breadcrumbs'][] = ['label' => 'Monedero Historicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monedero-historico-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?= Html::a(Yii::t('app', 'Atrás'), ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
