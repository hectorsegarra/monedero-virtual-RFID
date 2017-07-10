<?php
use yii\helpers\Url;
$urlModificarSaldo = Url::to(['//monedero/modificarsaldo'], true);

$js3 = <<<EOD
    //Esto hace que si apretamos intro estando en el campo de buscar se envie la busqueda
    $("#recargar-cantidad").keyup(function(event){
        if(event.keyCode == 13){
            $("#btn-recargar-saldo").click();
        }
    });

    // ##### Recarga saldo en un monedero ##### //
    $("#btn-recargar-saldo").click(function(){
        $.ajax({
            url: '$urlModificarSaldo',
            type: 'POST',
            dataType: 'json',
            data: {
                    "cantidad": $("#recargar-cantidad").val().replace(",", "."),
                    "monedero_id": $("#text-monedero-id").val(),
                    "tipo_operacion":"Recargar saldo",
                  },
            beforeSend: function(){
                $('#recargar-saldo').prop('disabled', true);
                $("#div-loading1").show();
            },
            success: function(data) {
                setTimeout(function() {//retrasa medio segundo la operacion.
                    $("#div-loading1").hide();
                    $('#recargar-saldo').prop('disabled', false);
                    $("#modal-recargar").modal('hide'); //esconde popup
                }, 500);
                $("#text-cantidad1").text(data);
                $("#text-cantidad2").text(data);
                $("#text-cantidad3").text(data);
                $("#recargar-cantidad").val("");
            },
            error: function(jqXHR, textStatus ) {
                alert( "Error inesperado #050 recargando monedero: " + textStatus );
            }
        });
    });
EOD;

$this->registerJs($js3);
?>
    <div><strong>Usuario seleccionado: </strong><span id="text-nombre3"></span></div>
    <br/>
    <div><strong>Saldo actual: </strong><span id="text-cantidad3"></span></div>
    <br/>

    <div style="color: green;"><strong>Cantidad a recargar: </strong></div>
    <input type="text" class="form-control" id="recargar-cantidad" placeholder="">
    <br/>

    <button type="submit" class="btn btn-default" id="btn-recargar-saldo">
        Recargar saldo <div style="display:none;" id="div-loading1" class="fa fa-spinner fa-pulse fa-fw"></div>
    </button>
