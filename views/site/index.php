<?php
use yii\helpers\Url;
use yii\bootstrap\Modal;

if (Yii::$app->user->isGuest) {
    Yii::$app->getResponse()->redirect(array('site/login'));
}





$urlBuscarDniTelefono = Url::to(['user/find-by-rfid'], true);

$js = <<<EOD

//Esto hace que si apretamos intro estando en el campo de buscar se envie la busqueda
$("#rfid").keyup(function(event){
    if(event.keyCode == 13){
        $("#btn_rfid").click();
    }
});

$('#ir-a-ver-ficha').click(function(){
    varId=$("#text-id").val();
    if(varId==''){
        alert("Debe seleccionar un usuario/a")
    }
    else{
        window.location.href='http://tarjetamediterranea.com/user/update?id='+varId;
    }
})

$("#btn_rfid").click(function(){
        $.ajax({
            url: '$urlBuscarDniTelefono',
            type: 'POST',
            dataType: 'json',
            data: {"rfid": $("#rfid").val()},
            success: function(data) {
                //$("#buscar_nombre").val("");
                if (data != null) {
                    $("#text-nombre").text(data.nombre);
                    $("#text-nombre2").text(data.nombre);
                    $("#text-nombre3").text(data.nombre);

                    $("#text-email").text(data.email);
                    $("#text-dni").text(data.dni);
                    $("#text-id").val(data.id);

                    $("#text-cantidad1").text(data.moneder_cantidad+' €');
                    $("#text-cantidad2").text(data.moneder_cantidad+' €');
                    $("#text-cantidad3").text(data.moneder_cantidad+' €');

                    $("#text-monedero-id").val(data.monederoid);
                }
            },
            error: function() {
                $("#text-nombre").text('');
                $("#text-nombre2").text('');
                $("#text-nombre3").text('');

                $("#text-email").text('');
                $("#text-dni").text('');
                $("#text-id").val('');

                $("#text-cantidad1").text('');
                $("#text-cantidad2").text('');
                $("#text-cantidad3").text('');

                $("#text-monedero-id").val('');
                alert('Usuario no encontrado.');
            }
        });

});

setTimeout(function() {
    $(".hide-3s").fadeOut(500);
}, 3000);

setTimeout(function() {
    $(".hide-10s").fadeOut(500);
}, 10000);
EOD;
$this->registerJs($js, \yii\web\View::POS_READY);









$this->title = 'Monedero virtual';
?>






<div class="row">
    <div class="col-lg-12">
        Bienvenido... 
    </div>
</div>

<br/>

<div class="row">
    <div class="col-lg-6" style="border:1px solid grey; padding-top:10px; padding-bottom:10px;">
        <strong><u>Búsqueda de usuarios</u></strong>
        <br/><br/>


        <label for="rfid">RFID:</label>

        <div class="input-group">
            <input type="text" id="rfid" class="form-control" placeholder="">
            <span class="input-group-btn">
                <button class="btn btn-default" id="btn_rfid" type="button"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
            </span>
        </div><!-- /input-group -->




        <br/>

        <div><strong>Nombre: </strong><span id="text-nombre"></span></div>
        <div><strong>Correo: </strong><span id="text-email"></span></div>
        <div><strong>DNI: </strong><span id="text-dni"></span></div>
        <br/>
        <div style="font-size:1.2em;"><strong>Saldo en monedero: </strong><span id="text-cantidad1"></span></div>

        <input type="hidden" class="form-control" id="text-id" placeholder="">
        <input type="hidden" class="form-control" id="text-monedero-id" placeholder="">




        <br/>
        <input type="button" class="btn btn-default" id="ir-a-ver-ficha" value="Ver ficha" />
        <?php
            //Boton para recargar saldo
            Modal::begin([
                'header' => '<h2>Recargar saldo</h2>',
                'id'=>'modal-recargar',
                'toggleButton' => ['class'=>'btn btn-default','label' => 'Recargar saldo'],
                'clientOptions' => [
                    'keyboard' => false,
                ],
            ]);
            echo $this->render('//monedero/_recargar_saldo', [
                'tipo_operacion' => "Recargar saldo",
            ]);
            Modal::end();
        ?>
        <?php
            //Boton para recargar Retirar saldo
            Modal::begin([
                'header' => '<h2>Retirar saldo</h2>',
                'id'=>'modal-retirar',
                'toggleButton' => ['class'=>'btn btn-default','label' => 'Retirar saldo'],
                'clientOptions' => [
                    'keyboard' => false,
                ],
            ]);
            echo $this->render('//monedero/_retirar_saldo', [
                'tipo_operacion' => "Retirar saldo",
            ]);
            Modal::end();
        ?>

    </div>
</div>
