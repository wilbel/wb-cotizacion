<style>
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



$titulo = esc_attr(!empty(get_option('_wb_data_datosEmpresa')['wbct_titulo']) ? get_option('_wb_data_datosEmpresa')['wbct_titulo'] : '');    
$valor_iva =  esc_attr(!empty(get_option('_wb_data_iva')['valor_iva']) ? get_option('_wb_data_iva')['valor_iva'] : "0");
$url_imagen = esc_attr(!empty(get_option('_wb_data_datosEmpresa')['wbct_logo']) ? get_option('_wb_data_datosEmpresa')['wbct_logo'] :  plugin_dir_url(__FILE__) . '../../static/imagenes/imagen_defecto.png');
$propietario = esc_attr(!empty(get_option('_wb_data_datosEmpresa')['wbct_propietario']) ? get_option('_wb_data_datosEmpresa')['wbct_propietario'] : '');
$cedulaRuc = esc_attr(!empty(get_option('_wb_data_datosEmpresa')['wbct_cedulaRuc']) ? get_option('_wb_data_datosEmpresa')['wbct_cedulaRuc'] : '');
$email = esc_attr(!empty(get_option('_wb_data_datosEmpresa')['wbct_email']) ? get_option('_wb_data_datosEmpresa')['wbct_email'] : '');
$telefono = esc_attr(!empty(get_option('_wb_data_datosEmpresa')['wbct_telefono']) ? get_option('_wb_data_datosEmpresa')['wbct_telefono'] : '');
$direccion = esc_attr(!empty(get_option('_wb_data_datosEmpresa')['wbct_direccion']) ? get_option('_wb_data_datosEmpresa')['wbct_direccion'] : '');
$descripcion  = esc_attr(!empty(get_option('_wb_data_datosEmpresa')['wbct_descripcion']) ? get_option('_wb_data_datosEmpresa')['wbct_descripcion'] : '');




?>

<div style="position:relative;display:flex;margin-bottom:0px;padding-bottom:0px">
    <div style="width:58%;position:absolute;left:0">
        <div style="text-align: center;"> <img  style="max-height: 112px; max-width:250px"  src="<?= $url_imagen ?>" alt="" width=""> </div>
        <br>
        <table style="width:100%" cellspacing="0" cellpadding="2">
            <?php foreach ($load_cliente  as  $key => $row) {  ?>
                <tr>
                    <td style="background: #D6D6D6;"> <label for="">Nombre:</label> </td>
                    <td> <?= $row->nombre; ?></td>
                </tr>
                <tr>
                    <td style="background: #D6D6D6;"><label for="">Email:</label></td>
                    <td> <?= $row->email; ?></td>
                </tr>
                <tr>
                    <td style="background: #D6D6D6;"> <label for="">ced/ruc:</label> </td>
                    <td> <?= $row->dni_ruc; ?> </td>
                </tr>
                <tr>
                    <td style="background: #D6D6D6;"> <label for="">Teléfono:</label> </td>
                    <td> <?= $row->telefono; ?> </td>
                </tr>
                <tr>
                    <td style="background: #D6D6D6;"> <label for="">Dirección:</label> </td>
                    <td> <?= $row->direccion; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="col-2" style="width:40%;text-align: center;top:0px;position:relative;">
        <h3 style="margin-top:0px"><?= $titulo; ?></h3>
        <table style="width:100%" cellspacing="0" cellpadding="2">
            <tr>
                <td style="background: #D6D6D6;"> <label>Nro Cotización</label></td>
                <td style="text-align: center;" ><label> <b> <?php echo $codigoCotizacion; ?></b></label></td>
            </tr>
            <tr>
                <td style="background: #D6D6D6;"><label for="">Fecha</label></td>
                <td> <?= $fecha; ?> </td>
            </tr>
        </table>
        <br>
        <table style="width:100%" cellspacing="0" cellpadding="2">
            <tr>
                <td style="background: #D6D6D6;"> <label>Propietario:</label></td>
                <td><label> <b> <?php echo $propietario; ?></b></label></td>
            </tr>
            <tr>
                <td style="background: #D6D6D6;"> <label>Ced/RUC:</label></td>
                <td><label> <b> <?php echo $cedulaRuc; ?></b></label></td>
            </tr>
            <tr>
                <td style="background: #D6D6D6;"><label>Email:</label></td>
                <td> <?= $email; ?> </td>
            </tr>
            <tr>
                <td style="background: #D6D6D6;"><label for="">Teléfono:</label></td>
                <td> <?= $telefono; ?> </td>
            </tr>
            <tr>
                <td style="background: #D6D6D6;"><label>Dirección:</label></td>
                <td> <?= $direccion; ?> </td>
            </tr>
        </table>
    </div>
</div>

<div style="margin-top:2%">
    <p style="padding:8px 0"><?= $descripcion; ?></p>
    <table style="width:100%" cellspacing="0" cellpadding="5">
        <thead class="headtable" style="background: #D6D6D6;">
            <tr>
                <th style="width: 5%;"> <?php _e("N°") ?></th>
                <th style="width: 20%;"> <?php _e("Producto") ?> </th>
                <th style="width: 35%;"> <?php _e("Descripción") ?> </th>
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
        <textarea style="height: auto; padding:5px;font: sans-serif;"><?= ($terminos_condiciones); ?></textarea>
    </div>
</div>