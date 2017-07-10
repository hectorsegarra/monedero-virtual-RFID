<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Monedero */

$this->title = \Yii::t('app', 'Crear {modelClass}', ['modelClass' => \Yii::t('app', 'app\models\Monedero')]);
$this->params['breadcrumbs'][] = ['label' => 'Monederos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monedero-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?= Html::a(Yii::t('app', 'Atrás'), ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
