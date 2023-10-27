<?php
require_once "../../conexion/database.php";
require_once "../../clases/Ventas.php";

$c = new conectar();
$conexion = $c->conexion();

$obj = new ventas();

// Consulta SQL
$sql =$sql = "SELECT
id_venta, -- Cambié el alias a id_venta
MAX(fechaCompra) AS fechaUltimaCompra,
id_cliente, -- Cambié el alias a id_cliente
SUM(totalVenta) AS totalVentas -- Cambié el alias a totalVentas
FROM
ventas
GROUP BY
id_venta, id_cliente"; 

// Ejecutar la consulta SQL
$result = mysqli_query($conexion, $sql);
?>

<h4>Reportes y ventas</h4>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered" style="text-align: center;">
                <caption><label>Ventas :)</label></caption>
                <tr>
                    
                    <td>Fecha</td>
                    <td>Cliente</td>
                    <td>Total de compra</td>
                    <td>Ticket</td>
                    <td>Reporte</td>
                </tr>
                <?php while ($ver = mysqli_fetch_row($result)) : ?>
                    <tr>
                        <td><?php echo $ver[0] ?></td>
                        <td><?php echo $ver[1] ?></td>
                        <td>
                            <?php
                            if ($obj->nombreCliente($ver[2]) == " ") {
                                echo "S/C";
                            } else {
                                echo $obj->nombreCliente($ver[2]);
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            echo "$" . $obj->obtenerTotal($ver[0]);
                            ?>
                        </td>
                        <td>
                            <a href="../procesos/ventas/crearTicketPdf.php?idventa=<?php echo $ver[0] ?>" class="btn btn-danger btn-sm">
                                Ticket <span class="glyphicon glyphicon-list-alt"></span>
                            </a>
                        </td>
                        <td>
                            <a href="../procesos/ventas/crearReportePdf.php?idventa=<?php echo $ver[0] ?>" class="btn btn-danger btn-sm">
                                Reporte <span class="glyphicon glyphicon-file"></span>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
    <div class="col-sm-1"></div>
</div>
