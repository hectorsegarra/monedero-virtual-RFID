<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = \Yii::t('app', 'Crear usuario');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Atrás'), ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
