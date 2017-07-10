<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Terminal Ventas';
$this->params['breadcrumbs'][] = $this->title;


$urlRealizarPago = Url::to(['monedero/realizar-pago'], true);
$js = <<<EOD
$("#rfid").keyup(function(event){
    if(event.keyCode == 13){
        $.ajax({
            url: '$urlRealizarPago',
            type: 'POST',
            dataType: 'json',
            data: {
                "rfid": $("#rfid").val(),
                "cantidad":'$dinero',
                "terminal_id":'$terminal_id',
                },
            beforeSend: function(){
                $("#ok").hide();
                $("#error").hide();
                $(".btn-cancelar").show();
                $("#loading").show();
                $("#rfid").val("");
            },
            success: function(data) {
                $("#loading").hide();
                $("#ok").show();
                $("#saldo-restante").text(data);
                $(".btn-cancelar").hide();
                setTimeout(function() {//retrasa medio segundo la operacion.
                     window.location.href = "/backend/terminal-ventas-fijacion-precio?terminal_id=$terminal_id";
                }, 4000);
            },
            error: function (request, status, error) {
                $("#loading").hide();
                $("#error").show();
                $("#mensaje-error").text(request.responseText);
                //alert(request.responseText);
            }
        });

    }
});
EOD;
$this->registerJs($js, \yii\web\View::POS_READY);
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

<div class="cuadro-lectura-rfid">
    <div>Usted está apunto de pagar <strong style="color:#074604; border-bottom: 2px solid #074604;"><?=$dinero?></strong> € si está de acuerdo pase su pulsera por el lector.</div>

    <div class="terminal-area-respuestas">

        <input type="text" autofocus autocomplete="off" style="color:white; border:0px solid white;" id="rfid">

        <div style="display:none;" id="loading">
            <i style="color:#35aed6" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
            <p style="font-size:18px;">Realizando pago, espere por favor</p>
        </div>

        <div style="display:none;" id="ok">
            <i style="color:#79cc70" class="fa fa-check-circle-o fa-3x fa-fw" aria-hidden="true"></i>
            <p style="font-size:18px;">
                Pago realizado correctamnete<br/>
                <span>Saldo restante: <strong><span id="saldo-restante">????</span> €</strong></span>
                <br/>
                <br/>
                En 4 segundos regresará al inicio
            </p>
        </div>

        <div style="display:none;" id="error">
            <i style="color:#c75b50" class="fa fa-exclamation-triangle fa-3x fa-fw" aria-hidden="true"></i>
            <p style="font-size:18px;">
                <span id="mensaje-error"></span>
            </p>
        </div>



    </div>

    <a href="<?=Url::to(['backend/terminal-ventas-fijacion-precio?terminal_id='.$terminal_id], true);?>"><div class="btn-cancelar">CANCELAR</div></a>

</div>
