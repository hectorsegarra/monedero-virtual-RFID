<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Estadisticas';
$this->params['breadcrumbs'][] = $this->title;
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawChart2);
      google.charts.setOnLoadCallback(drawChart3);

      /*PARA EL RESTO DE ESTADISTICAS*/
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Tipo de operacion', 'Numero de operaciones'],
          <?php
            foreach ($movimientos as $movimiento) {
                echo "['".$movimiento['tipo_operacion']."',".$movimiento['num']."],";
            }
          ?>
        ]);
        var options = {
          title: 'Distribución de operaciones por tipo (total)',
          legend: 'none'
        };
        var chart = new google.visualization.PieChart(document.getElementById('movimientos-totales'));
        chart.draw(data, options);
    }


      /*PARA LAS ESTADISTICAS DEL MES ACTUAL*/
      function drawChart2() {
        var data = google.visualization.arrayToDataTable([
          ['Tipo de operacion', 'Numero de operaciones'],
          <?php
            foreach ($movimientos_este_mes as $movimiento) {
                echo "['".$movimiento['tipo_operacion']."',".$movimiento['num']."],";
            }
          ?>
        ]);
        var options = {
          title: 'Distribución de operaciones por tipo (mes actual)',
          legend: 'none',
        };
        var chart = new google.visualization.PieChart(document.getElementById('movimientos-este-mes'));
        chart.draw(data, options);
      }


      /*PARA LAS ESTADISTICAS DE NUMERO DE PAGOS POR MES DEL AÑO ACTUAL*/
      <?php
        $arrayAyudante=[0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($movimientos_por_meses_este_anyo as $mes) {
            $arrayAyudante[$mes['mes']]=$mes['num'];
        }
        $arrayMeses=['enero','febrero','marzo','abril','mayo','junio','julio', 'agosto','septiembre','octubre','noviembre','diciembre'];
      ?>
      function drawChart3() {
        var data = google.visualization.arrayToDataTable([
          ['Mes', 'Numero pagos',],
          <?php
            foreach ($arrayAyudante as $key=>$mes) {
                echo "['".$arrayMeses[$key]."',".$mes."],";
            }
          ?>
        ]);

        var options = {
          title: 'Numero de pagos por mes del año actual',
          legend: 'none',
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }


</script>



<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class='row'>
        <div class="col-lg-12" style="padding:10px;">
            <div id="curve_chart" style="border:1px solid grey;border-radius:5px; width: 100%; height: 500px;"></div>
        </div>
    </div>

    <div class='row'>
        <div class="col-lg-6" style="padding:10px;">
            <div id="movimientos-totales" style="border:1px solid grey;border-radius:5px; width: 100%; height: 500px;"></div>
        </div>
        <div class="col-lg-6" style="padding:10px;">
            <div id="movimientos-este-mes" style="border:1px solid grey;border-radius:5px; width: 100%; height: 500px;"></div>
        </div>
    </div>


</div>
