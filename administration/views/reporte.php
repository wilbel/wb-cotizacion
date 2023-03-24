<style>
    .cabezera {
        display: flex;
      height: auto;
    }

    .col-2 {
        margin-left: 60%;
    }

    .headtable {
        border: 1px solid;

    }

    th {
        border: 1px solid;

    }

    td {
        border: 1px solid;

    }

    .tdhidden {
        border: 0 solid;
    }
</style>


<?php
$codigoCotizacion = ($_POST['codigo_cotizacion']);
$wrpro_load_datos = new  WBCT_database();
$cargarCotizacion = $wrpro_load_datos->wbct_buscar_proforma_id("wbct_cotizacion", $codigoCotizacion);
foreach ($cargarCotizacion  as  $key => $row) {
    $id_cliente = $row->id_cli;
    $fecha = $row->fecha;
    $subtotal_proforma =  $row->subtotal;
    $decuento = $row->descuento;
    $subtotal_desc = $row->subtotalall;
    $iva_proforma =  $row->iva;
    $total_proforma = $row->total;
    $terminos_condiciones = $row->terminos_condiciones;
}
$load_cliente = $wrpro_load_datos->wbct_buscar_proforma_id("wbct_cliente",  $id_cliente);
$cargarDetalleCotizacion = $wrpro_load_datos->wbct_buscar_detalle_id("wbct_detalle_cotizacion",  $codigoCotizacion);
$titulo = esc_attr(get_option('_wb_data_imagen')['wbct_titulo']);
$url_imagen = esc_attr(get_option('_wb_data_imagen')['wbct_logo']);
?>

<div class="cabezera">
    <div style="width:58%">
        <div style="text-align: center;"> <img src="<?= $url_imagen ?>" alt="" width="150px" height="150px"> </div>
        <br>
        <table style="width:100%" cellspacing="0" cellpadding="2">
            <?php foreach ($load_cliente  as  $key => $row) {  ?>
                <tr>
                    <td> <label for="">Nombre</label> </td>
                    <td> <?= $row->nombre; ?></td>
                </tr>
                <tr>
                    <td><label for="">Email</label></td>
                    <td> <?= $row->email; ?></td>
                </tr>
                <tr>
                    <td> <label for="">ced/ruc</label> </td>
                    <td> <?= $row->dni_ruc; ?> </td>
                </tr>
                <tr>
                    <td> <label for="">telefono</label> </td>
                    <td> <?= $row->telefono; ?> </td>
                </tr>
                <tr>
                    <td> <label for="">direccion</label> </td>
                    <td> <?= $row->direccion; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="col-2" style="width:40%;text-align: center;">
        <h3><?= $titulo; ?></h3>
        <table style="width:100%" cellspacing="0" cellpadding="2">
            <tr>
                <td> <label>Nro Cotización</label></td>
                <td><label> <b> <?php echo $codigoCotizacion; ?></b></label></td>
            </tr>
            <tr>
                <td><label for="">Fecha</label></td>
                <td> <?= $fecha; ?> </td>
            </tr>
        </table>
        <br>
        <table style="width:100%" cellspacing="0" cellpadding="2">
            <tr>
                <td> <label>RUC</label></td>
                <td><label> <b> <?php echo $codigoCotizacion; ?></b></label></td>
            </tr>
            <tr>
                <td><label>Email</label></td>
                <td> <?= $fecha; ?> </td>
            </tr>
            <tr>
                <td><label for="">telefono:</label></td>
                <td> <?= $fecha; ?> </td>
            </tr>
            <tr>
                <td><label>Dirección</label></td>
                <td> <?= $fecha; ?> </td>
            </tr>
        </table>
    </div>
</div>
<p>hola mundo</p>

<table style="width:100%" cellspacing="0" cellpadding="5">
    <thead class="headtable">
        <tr>
            <th style="width: 5%;"> <?php _e("N°") ?></th>
            <th style="width: 20%;"> <?php _e("Producto") ?> </th>
            <th style="width: 35%;"> <?php _e("Descripcion") ?> </th>
            <th style="width: 10%;"> <?php _e("Cantidad") ?> </th>
            <th style="width: 15%;"> <?php _e("Precio") ?> </th>
            <th style="width: 15%;"> <?php _e("Total") ?> </th>
        </tr>
    </thead>
    <?php
    if (!empty($cargarDetalleCotizacion)) {
        foreach ($cargarDetalleCotizacion as  $key => $row) { ?>
            <tr style="color:black;font-size:14px;">
                <?php
                $nombre_producto = $wrpro_load_datos->wbct_retornar_nombre_producto("wbct_producto", $row->codigo_producto);
                $descripcion_producto = $wrpro_load_datos->wbct_retornar_descripcion_producto("wbct_producto", $row->codigo_producto); ?>
                <td><?= $key + 1; ?> </td>
                <td><?= $nombre_producto ?> </td>
                <td><?= $descripcion_producto ?></td>
                <td><?= $row->cant_item; ?></td>
                <?php $cantidad_decimales = strpos(strrev($row->prec_unit), ".");
                if ($cantidad_decimales < 3) {
                    $precio_uni_formateado = number_format($row->prec_unit, 2, '.', '');
                } else {
                    $precio_uni_formateado = number_format($row->prec_unit, 6, '.', '');
                } ?>
                <td>
                    <?= $precio_uni_formateado; ?>
                </td>
                <td><?= number_format($row->subtotal, 2, '.', '') ?></td>
            </tr>
    <?php  }
    }
    ?>
    <tr>
        <td colspan='4' class="tdhidden"></td>
        <td>Subtotal</td>
        <td>$ <?= number_format($subtotal_proforma, 2, '.', '') ?></td>
    </tr>
    <tr>
        <td colspan='4' class="tdhidden"></td>
        <td>Desc. $:</td>
        <td> $ <?= number_format($decuento, 2, '.', '') ?>
    </tr>
    <tr>
        <td colspan='4' class="tdhidden"></td>
        <td>Subt. Desc:</td>
        <td> $ <?= number_format($subtotal_desc, 2, '.', '') ?></td>
    </tr>
    <tr>
        <td colspan='4' class="tdhidden"></td>
        <td>IVA <?= ($valor_iva * 100) ?>%:</td>
        <td> $ <?= number_format($iva_proforma, 2, '.', '') ?></td>
    </tr>
    <tr>
        <td colspan='4' class="tdhidden"></td>
        <td>Total:</td>
        <td> $ <?= number_format($total_proforma, 2, '.', '') ?></td>
    </tr>
</table>
<div>
    <p>Observaciones/Instrucciones</p>
    <textarea style="height: auto;"><?= ($terminos_condiciones); ?></textarea>
</div>