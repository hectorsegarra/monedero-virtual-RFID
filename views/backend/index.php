<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mes', 'usuarios activos', 'Cuotas pagadas','Cuotas_impagadas'],
          ['<?=date('m-Y', strtotime('-3 month'))?>',  <?=$numero_activos_menos_3_mes?>,      <?=$numero_cuotas_al_dia_menos_3_mes?>, <?=$numero_activos_menos_3_mes-$numero_cuotas_al_dia_menos_3_mes?>],
          ['<?=date('m-Y', strtotime('-2 month'))?>',  <?=$numero_activos_menos_2_mes?>,      <?=$numero_cuotas_al_dia_menos_2_mes?>, <?=$numero_activos_menos_2_mes-$numero_cuotas_al_dia_menos_2_mes?>],
          ['<?=date('m-Y', strtotime('-1 month'))?>',  <?=$numero_activos_menos_1_mes?>,      <?=$numero_cuotas_al_dia_menos_1_mes?>, <?=$numero_activos_menos_1_mes-$numero_cuotas_al_dia_menos_1_mes?>],
          ['<?=date('m-Y')?>',  <?=$numero_activos?>,  <?=$numero_cuotas_al_dia?>, <?=$numero_activos-$numero_cuotas_al_dia?>],
        ]);

        var options = {
          title: 'Cuotas del centro deportivo (4 meses)',
          curveType: 'line',
          colors: ['#4655db', '#55c942', '#df6767'],
          legend: { position: 'bottom' }

        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
        }






        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart2);

        function drawChart2() {
        var data = google.visualization.arrayToDataTable([
            ['Nombre cuota', 'Personas inscritas'],
            <?php
                if(isset($estadisticas_por_cuotas)){
                    foreach ($estadisticas_por_cuotas as $cuota) {
                        echo "['".str_replace('Cuota', '', $cuota['cuota'])."',".$cuota['numero']."],";
                    }
                }
            ?>

        ]);

        var options = {
          title: 'Personas inscritas por cuota',
          legend: { position: 'none' }

        };

        var chart2 = new google.visualization.PieChart(document.getElementById('grafico_tipo_cuotas'));

        chart2.draw(data, options);
        }

    <?php
        if(isset($pagos_por_dia)){
            $vector_dias=[];
            for ($i = 1; $i <= 10; $i++) {
                $vector_dias[$i]=0;
            }
            foreach ($pagos_por_dia as $pago_dia) {
                $vector_dias[$pago_dia['dia']]+=$pago_dia['num_pagos'];
            }
            foreach ($vector_dias as $key => $pago_dia) {
                $vector_dias[$key]=$pago_dia/2;
            }
        }
    ?>


google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBarColors);

function drawBarColors() {
      var data = google.visualization.arrayToDataTable([
        ['Cuotas', 'Número de cuotas abonadas'],
        <?php
        if(isset($vector_dias)){
            foreach ($vector_dias as $key => $pago_dia) {
                echo "['".$key."', ".$pago_dia."],";
            }
        }
        ?>
      ]);

      var options = {
        title: 'Número de cuotas abonadas por día (media de los dos meses anteriores)',

        colors: ['#b0120a'],
        legend: { position: 'none' },

      };
      var chart = new google.visualization.ColumnChart(document.getElementById('grafico_barras'));
      chart.draw(data, options);
    }




















    </script>

<?php

if (Yii::$app->user->isGuest) {
    Yii::$app->getResponse()->redirect(array('site/login'));
}
$this->title = 'GCD - Gestión de centros deportivos';
?>




<div class="row">
    <div class="col-lg-4">
        <div style="border:solid grey 1px;">
            <div style="font-weight: bold;">Usuarios con cuota activa</div>
            <div style="font-size:0.8em">Usuarios que tienen una cuota asignada.</div>
            <div style="margin-right:6px; font-size:1.4em; text-align: right;"><?=$numero_activos?></div>
        </div>
    </div>



    <div class="col-lg-4">
        <div style="border:solid grey 1px;">
            <div style="font-weight: bold;">Cuotas al día</div>
            <div style="font-size:0.8em">Usuarios que tienen pagado el mes actual.</div>
            <div style="margin-right:6px; font-size:1.4em; text-align: right; color:green;"><?=$numero_cuotas_al_dia?></div>
        </div>
    </div>

    <div class="col-lg-4">
        <div style="border:solid grey 1px;">
            <div style="font-weight: bold;">Cuotas impagadas</div>
            <div style="font-size:0.8em">Usuarios que no han pagado el mes actual o los anteriores.</div>
            <div style="margin-right:6px; font-size:1.4em; text-align: right; color:red;"><?=$numero_cuotas_impagadas?></div>
        </div>
    </div>
</div>

<br/>


<div class="row">
    <div class="col-lg-8" >
        <div id="curve_chart" style="height:400px; border: solid grey 1px;"></div>
    </div>

    <div class="col-lg-4" >
        <div id="grafico_tipo_cuotas" style="height:400px; border: solid grey 1px;"></div>
    </div>
</div>

<br/>

<div class="row">
    <div class="col-lg-6">
        <div style="border:1px solid grey; padding: 4px;">
            <div style="text-align: center; font-weight: bold; color:#494ad0;"><i class="fa fa-birthday-cake" aria-hidden="true"></i> Próximos cumpleaños de personas con cuota activa <i class="fa fa-birthday-cake" aria-hidden="true"></i></div>
            <div style="margin-top: 4px; border-bottom: 2px solid #adadad; padding-bottom:6px;">
                 <strong>Cumpleaños de hoy</strong><br/>
                <?php
                $primero=1;
                if (isset($usuarios_cumpleanyos)){
                    foreach ($usuarios_cumpleanyos as $usuario_cumple) {
                        if($usuario_cumple['dia_cumple']!=date("j/n") && $primero==1){
                            $primero=0;
                            echo "</div>";
                            echo '<div style="margin-top: 4px;">';
                                echo '<strong>Cumpleaños próximos 3 días</strong><br/>';
                        }
                        if($usuario_cumple['dia_cumple']!=date("j/n")){
                            $edad=$usuario_cumple['edad']+1;
                        }
                        else{
                            $edad=$usuario_cumple['edad'];
                        }
                        ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;<a style="color:black; text-decoration:none;" href="http://castellonpadelreserva.com/user/update?id=<?=$usuario_cumple['id']?>"><?=$usuario_cumple['nombre']?>, <?=$usuario_cumple['apellidos']?> - ( el <?=$usuario_cumple['dia_cumple']?> cumple: <?=$edad?> años)</a><br/>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6" >
        <div style="border:1px solid grey; padding: 4px;">
            <div id="grafico_barras" ></div>
        </div>
    </div>
</div>










<?php
function getRealIP() {

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDR'];
}
$var=getRealIP();

if ($var=="81.43.127.162"){?>


<?php  } ?>
