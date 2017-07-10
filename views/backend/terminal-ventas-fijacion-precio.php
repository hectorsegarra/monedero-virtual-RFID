
<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Terminal Ventas';
$this->params['breadcrumbs'][] = $this->title;
?>



<script>
    $(document).ready(function(){
       $('.table_teclado .btn-teclado').click(function(){
           var number = $(this).text();

           if (number == 'BORRAR')
           {
               $('#campo').val($('#campo').val().substr(0, $('#campo').val().length - 1)).focus();
           }
           else
           {
               $('#campo').val($('#campo').val() + number).focus();
           }

       });

       $('.btn-cobrar').click(function(){
           var number = $('#campo').val();
           window.location.href = "<?=Url::home(true);?>backend/terminal-ventas-lectura-rfid?dinero="+number+"&terminal_id=<?=$terminal_id?>";
       });
    });
</script>

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
    <div class="parte-izquierda">
        <a href="/backend/terminal-ventas-menu-terminal?terminal_id=<?=$terminal_id?>"><div class="btn-ir-menu">IR AL MENÚ</div></a>
        <input type="text" readonly id="campo" class="teclado_text">
    </div>
    <div class="btn-cobrar">COBRAR</div>

    <br/>

    <div class="table_teclado">
        <div class="btn-teclado">7</div>
        <div class="btn-teclado">8</div>
        <div class="btn-teclado">9</div>
        <br/>
        <div class="btn-teclado">4</div>
        <div class="btn-teclado">5</div>
        <div class="btn-teclado">6</div>
        <br>
        <div class="btn-teclado">1</div>
        <div class="btn-teclado">2</div>
        <div class="btn-teclado">3</div>
        <br>
        <div class="btn-teclado">0</div>
        <div class="btn-teclado">.</div>
        <div class="btn-teclado borrar">BORRAR</div>
    </div>

</div>
