<?php
use yii\helpers\Url;
$urlModificarSaldo = Url::to(['//monedero/modificarsaldo'], true);

$js2 = <<<EOD
    //Esto hace que si apretamos intro estando en el campo de buscar se envie la busqueda
    $("#retirar-cantidad").keyup(function(event){
        if(event.keyCode == 13){
            $("#btn-retirar-saldo").click();
        }
    });

    // ##### Retira saldo en un monedero ##### //
    $("#btn-retirar-saldo").click(function(){
        $.ajax({
            url: '$urlModificarSaldo',
            type: 'POST',
            dataType: 'json',
            data: {
                    "cantidad": "-"+$("#retirar-cantidad").val().replace(",", "."),
                    "monedero_id": $("#text-monedero-id").val(),
                    "tipo_operacion":"Retirar saldo",
                  },
            beforeSend: function(){
              $('#retirar-saldo').prop('disabled', true);
              $("#div-loading2").show();
            },
            success: function(data) {
                setTimeout(function() {//retrasa medio segundo la operacion.
                    $("#div-loading2").hide();
                    $('#retirar-saldo').prop('disabled', false);
                    $("#modal-retirar").modal('hide'); //esconde popup
                }, 500);
                $("#text-cantidad1").text(data);
                $("#text-cantidad2").text(data);
                $("#text-cantidad3").text(data);
                $("#retirar-cantidad").val("");
            },
            error: function() {
                alert( "Error inesperado #050 retirando saldo de monedero");
            }
        });

    });
EOD;

$this->registerJs($js2);
?>

    <div><strong>Usuario seleccionado: </strong><span id="text-nombre2"></span></div>
    <br/>
    <div><strong>Saldo actual: </strong><span id="text-cantidad2"></span></div>
    <br/>

    <div style="color: green;"><strong>Cantidad a retirar: </strong></div>
    <input type="text" class="form-control" id="retirar-cantidad" placeholder="">
    <br/>

    <button type="submit" class="btn btn-default" id="btn-retirar-saldo">
        Retirar saldo <div style="display:none;" id="div-loading2" class="fa fa-spinner fa-pulse fa-fw"></div>
    </button>
