<?php
define('CANT_ITEMS_BY_PAGE', 10);
$querys = new WBCT_database();
$dato_search = !empty($_POST["dato_search"]) ? $_POST["dato_search"] : '';
$pagina = !empty($_POST["pagina"]) ? $_POST["pagina"] : 1;
$limit = CANT_ITEMS_BY_PAGE;
$offset = ($pagina - 1) * CANT_ITEMS_BY_PAGE;
global $wpdb;
$codigo = $_POST['codigo'];
$conteo = $querys->wbct_count_bd('wbct_cotizacion', '');
$paginas = ceil($conteo / CANT_ITEMS_BY_PAGE);
$datos_busquedad =  ' CONCAT(' . $wpdb->prefix . 'wbct_cotizacion.id," ",fecha," ",subtotal," ",descuento," ",iva," ",subtotalall," ",total,' . $wpdb->prefix . 'wbct_cliente.nombre) LIKE "%' . $dato_search . '%"';
$datos = $wpdb->prefix . 'wbct_cotizacion.id,fecha ,subtotal,descuento, iva,subtotalall, total,' . $wpdb->prefix . 'wbct_cliente.nombre';
$where =  ' WHERE ' . $datos_busquedad . ' AND ' . $wpdb->prefix . 'wbct_cotizacion.id_cli= ' . $wpdb->prefix . 'wbct_cliente.id  ORDER BY ' .  $wpdb->prefix . 'wbct_cotizacion.id DESC LIMIT ' . $limit . ' OFFSET ' . $offset;
$load_proformas = $querys->wbct_tables_multiple('wbct_cotizacion', 'wbct_cliente', $datos, $where); ?>


<table class="table-responsive  table table-striped" style="font-size:12px;">
    <thead style="background-color:#f7f7f7 ;color:#000000;font-weight: bold;">
        <tr>
            <th style="width: 5%;" class="text-center"> <?php _e("N°") ?></th>
            <th style="width: 40%;" class="text-center"> <?php _e("Cliente") ?> </th>
            <th style="width: 15%;" class="text-center"> <?php _e("Fecha") ?> </th>
            <th style="width: 5%;" class="text-center"> <?php _e("Subtotal") ?> </th>
            <th style="width: 5%;" class="text-center"> <?php _e("Desc.") ?> </th>
            <th style="width: 5%;" class="text-center"> <?php _e("IVA") ?> </th>
            <th style="width: 10%;" class="text-center"> <?php _e("Total") ?> </th>
            <th style="width: 10%;" class="text-center"> <?php _e("Accion") ?></th>
        </tr>
    </thead>
    <?php
    if (!empty($load_proformas)) {
        foreach ($load_proformas as  $key => $proforma) { ?>
            <tr style="color:black;font-size:14px;">
                <td class="text-center"><?= $proforma->id;  ?></td>
                <td class="text-center"> <?= $proforma->nombre;  ?> </td>
                <td class="text-center"> <?= $proforma->fecha; ?> </td>
                <td class="text-center"> <?= number_format($proforma->subtotal, 2, '.', ''); ?> </td>
                <td class="text-center"> <?= number_format($proforma->descuento, 2, '.', ''); ?> </td>
                <td class="text-center"> <?= number_format($proforma->iva, 2, '.', ''); ?></td>
                <td class="text-center"><?= number_format($proforma->total, 2, '.', ''); ?></td>
                <td class="text-center">
                    <div class="row">
                        <div class="form-group col-sm-4 text-center">
                            <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                <input type='hidden' name='action' value='wbct-imprimir-cotizacion'>
                                <input type='hidden' name='codigo_cotizacion' value='<?= $proforma->id; ?>'>
                                <input type='hidden' name='crud' id="crud" value='add'>
                                <button class="btn btn-secondary"> <i class="fas fa-print"></i> </button>
                            </form>
                        </div>

                        <div class="form-group col-sm-4 text-center">
                            <form method="GET" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                <input type='hidden' name='action' value='wrpro-pro-proforma'>
                                <input type='hidden' name='crud' id="crud" value='load'>
                                <button class="btn btn-secondary" id="id_proforma" name="id_proforma" value="<?= $proforma->id; ?>"><i class="fas fa-edit"></i></button>
                            </form>
                        </div>

                        <div class="form-group col-sm-4 text-center">
                            <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                <input type='hidden' name='action' value='wrpro-pro-proforma'>
                                <input type='hidden' name='crud' id="crud" value='remove'>
                                <button class="btn btn-secondary"  name="eliminar_proforma" value="<?= $proforma->id; ?>" onclick="return validarDelete();"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
    <?php  }
    } else {
        echo "<tr><td class='text-center' colspan='8'>" . __('No existen datos') . "</td></tr>";
    }
    ?>
</table>



<?php
$diferencia = $paginas - $pagina;
$start_loop = $pagina;
if ($diferencia <= CANT_ITEMS_BY_PAGE) {
    $start_loop =   ($paginas - CANT_ITEMS_BY_PAGE);
}
$end_loop = $start_loop + (CANT_ITEMS_BY_PAGE); ?>
<nav>
    <div class="wr-paginacion">
        <p>Pagina <?php echo $pagina ?> / <?php echo $paginas ?> de <?php echo $conteo ?> datos</p>

        <ul class="wr-pagination">
            <li class="page-item">
                <a onclick="wbct_buscar_informacion('<?= 1; ?>','inicio.php','<?= $codigo; ?>')">Inicio</a>
            </li>
            <?php if ($pagina > 1) { ?>
                <li class="page-item">
                    <a onclick="wbct_buscar_informacion('<?php echo $pagina - 1 ?>','inicio.php','<?= $codigo; ?>')">
                        <span aria-hidden="true">
                            << </span>
                    </a>
                </li>
            <?php } ?>
            <?php for ($i = $start_loop; $i <= $end_loop; $i++) { ?>
                <?php if ($i > 0) { ?>
                    <li>
                        <a class="<?php if ($i == $pagina) echo "wr-paginacion-active" ?>" onclick="wbct_buscar_informacion('<?php echo $i ?>','inicio.php','<?= $codigo; ?>')">
                            <?php echo $i ?></a>
                    </li>
            <?php }
            } ?>
            <?php if ($pagina < $end_loop) {  ?>
                <li>
                    <a onclick="wbct_buscar_informacion('<?php echo $pagina + 1 ?>','inicio.php','<?= $codigo; ?>')">
                        <span aria-hidden="true">>></span>
                    </a>
                </li>
                <li class="page-item">
                    <a onclick="wbct_buscar_informacion('<?= $paginas; ?>','inicio.php','<?= $codigo; ?>')">Ultima</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>