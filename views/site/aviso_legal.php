<link href='http://fonts.googleapis.com/css?family=Courgette&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<?php
use yii\helpers\Html;
use app\components\InttegrumHelpers;
use \yii\helpers\Url;
use app\models\Texto;
/* @var $this yii\web\View */
$this->title = 'Yii 2 - Inttegrum - Aviso Legal';

$arrayTextos = Texto::getTextosPorCategoria('avisolegal');

echo Texto::getTexto(1, 'avisolegal', $arrayTextos);
echo Texto::editTexto(1, 'avisolegal', 'aviso-legal', true);