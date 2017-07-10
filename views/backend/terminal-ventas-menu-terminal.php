
<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Terminal Ventas';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    body {
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      width: 320px;
      height: 480px;
      overflow: hidden;
  }
</style>

<div class="contenedor-teclado">
    <div class="table_teclado">
        <a href="/backend/terminal-ventas-fijacion-precio?terminal_id=<?=$terminal_id?>"><div class="btn-teclado-menu">COBRAR</div></a>
        <a href="#"><div class="btn-teclado-menu-off">DEVOLVER ULTIMO COBRO</div></a>
        <a href="#"><div class="btn-teclado-menu-off">ANULAR ULTIMO COBRO</div></a>
        <a href="#"><div class="btn-teclado-menu-off">ANULAR ULTIMA DEVOLUCION</div></a>
    </div>

</div>
