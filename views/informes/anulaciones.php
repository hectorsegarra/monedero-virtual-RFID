<style>
    th, td {
        padding: 4px;
    }
</style>

<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Informe de anulaciones';
?>

<h3>Informe de anulaciones</h3>
<h4>Mes: <?=$filtros['mes'];?> Año: <?=$filtros['anyo'];?></h4>



<table border="1">
  <tr style="background-color:grey; color:white;">
    <th>Fecha</th>
    <th>Tipo</th>
    <th>Importe</th>
    <th>Concepto</th>
    <th>Propietario monedero</th>
    <th>Terminal</th>
  </tr>
<?php
foreach ($pagos as $pago) {
    ?>
    <tr>
      <th><?=$pago['fecha_hora']?></th>
      <th><?=$pago['tipo_operacion']?></th>
      <th><?=$pago['importe']?></th>
      <th><?=$pago['concepto']?></th>
      <th><?=$pago['nombre']?>, <?=$pago['apellidos']?></th>
      <th><?=$pago['t_nombre']?></th>
    </tr>
    <?php
}
?>
</table>
