<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Informes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-3">
            <label for="mes">Mes</label>
            <select class="form-control" id="mes">
                <option value="01">Enero</option>
                <option value="02">Febrero</option>
                <option value="03">Marzo</option>
                <option value="04">Abril</option>
                <option value="05">Mayo</option>
                <option value="06">Junio</option>
                <option value="07">Julio</option>
                <option value="08">Agosto</option>
                <option value="09">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
        </div>

        <div class="col-lg-3">
            <label for="anyo">Año</label>
            <input type="text" class="form-control" id="anyo">
        </div>

        <div class="col-lg-3">
            <label for="terminal">Terminal</label>
            <select class="form-control" id="terminal">
                <?php
                foreach ($terminales as $terminal){
                    ?>
                    <option value='<?=$terminal['id']?>'><?=$terminal['nombre']?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>

    <br/><br/>

    <script>
    function generar(informe){
        anyo=$("#anyo").val();
        mes=$("#mes").val();
        terminal=$("#terminal").val();
        if(anyo!="" && mes!=""){
            //window.location.replace("<?=Url::home(true);?>backend/"+informe+"?anyo="+anyo+"&mes="+mes+"&terminal="+terminal);
            window.open("<?=Url::home(true);?>backend/"+informe+"?anyo="+anyo+"&mes="+mes+"&terminal_id="+terminal);
        }else{
            alert("Es necesario seleccionar un año y un mes.");
        }
    }
    </script>

    <div class="row">
        <div class="col-lg-12">
            <div class="contenedor-informes">
                <div><strong>Informe de movimientos</strong></div>
                <div>Informe que contiene todos los movimientos (de cualquier tipo) realizados por los usuarios durante el mes y el año seleccionados en el desplegable.</div>
                <button type="button" onclick="generar('informe-movimientos')" class="btn btn-default">Generar informe</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="contenedor-informes">
                <div><strong>Informe de pagos</strong></div>
                <div>Informe que contiene todos los pagos realizados por los usuarios durante el mes y el año seleccionados en el desplegable.</div>
                <button type="button" onclick="generar('informe-pagos')" class="btn btn-default">Generar informe</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="contenedor-informes">
                <div><strong>Informe de devoluciones</strong></div>
                <div>Informe que contiene todas las devoluciones realizadas por los usuarios durante el me, el año y el terminal seleccionados</div>
                <button type="button" onclick="generar('informe-devoluciones')" class="btn btn-default">Generar informe</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="contenedor-informes">
                <div><strong>Informe de anulaciones</strong></div>
                <div>Informe que contiene todas las anulaciones realizadas por los usuarios durante el me, el año y el terminal seleccionados.</div>
                <button type="button" onclick="generar('informe-anulaciones')" class="btn btn-default">Generar informe</button>
            </div>
        </div>
    </div>


</div>
