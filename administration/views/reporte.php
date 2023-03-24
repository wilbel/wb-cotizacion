<style>
    .cabezera {
        display: flex;

    }

    .col-2 {
        margin-left: 50%;
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

    <div style="width:250px">
        <img src="<?= $url_imagen ?>" alt="" width="150px" height="150px">


        <br>

        <?php foreach ($load_cliente  as  $key => $row) {  ?>
            <label for="">Nombre</label>
            <input type="text" value="<?= $row->nombre; ?>">
            <label for="">Email</label>
            <input type="text" value="<?= $row->email; ?>">

            <label for="">ced/ruc</label>
            <input type="text" value="<?= $row->dni_ruc; ?>">

            <label for="">telefono</label>
            <input type="text" value="<?= $row->telefono; ?>">

            <label for="">direccion</label>
            <input type="text" value="<?= $row->direccion; ?>">
        <?php  }    ?>
    </div>

    <div class="col-2">
        <h3><?= $titulo; ?></h3>

        
        <label>Nro Cotización</label>
        <label><?php echo $codigoCotizacion; ?></label>
        
        
        
        
        <br>
        <label for="">Fecha</label><br>
        <input type="text" value="<?= $fecha; ?>">
    </div>
</div>

<table style="width:100%" cellspacing="0" cellpadding="5">
    <thead class="headtable">
        <tr>
            <th style="width: 5%;" class="text-center"> <?php _e("N°") ?></th>
            <th style="width: 20%;" class="text-center"> <?php _e("Producto") ?> </th>
            <th style="width: 35%;" class="text-center"> <?php _e("Descripcion") ?> </th>
            <th style="width: 10%;" class="text-center"> <?php _e("Cantidad") ?> </th>
            <th style="width: 15%;" class="text-center"> <?php _e("Precio") ?> </th>
            <th style="width: 15%;" class="text-center"> <?php _e("Total") ?> </th>
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
    } else {
        echo "<tr><td class='text-center' colspan='8'>" . __('No existen datos') . "</td></tr>";
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





<footer>



</footer>