<?php
define('CANT_ITEMS_BY_PAGE', 10);
$querys = new  WBCT_database();
$dato_search = !empty($_POST["dato_search"]) ? $_POST["dato_search"] : '';
$pagina = !empty($_POST["pagina"]) ? $_POST["pagina"] : 1;
$limit = CANT_ITEMS_BY_PAGE;
$offset = ($pagina - 1) * CANT_ITEMS_BY_PAGE;
global $wpdb;
$codigo = $_POST['codigo'];
$conteo = $querys->wbct_count_bd('wbct_cliente', '');
$paginas = ceil($conteo / CANT_ITEMS_BY_PAGE);
$datos_busquedad =  ' CONCAT(' . $wpdb->prefix . 'wbct_cliente.id," ",nombre," ",email," ",dni_ruc," ",telefono," ",direccion) LIKE "%' . $dato_search . '%"';
$lista_cliente = $querys->wbct_listar_bd_id('wbct_cliente', ' WHERE ' . $datos_busquedad . ' ORDER BY id DESC LIMIT ' . $limit . ' OFFSET ' . $offset); ?>

<table class="table-responsive table table-striped" style="font-size:12px;">
    <thead style="background-color:#f7f7f7 ;color:#000000;font-weight: bold;">
        <tr>
            <th style="width:5%;" class="text-center"><?php _e("#") ?></th>
            <th style="width:30%;" class="text-center"><?php _e("NOMBRE CLIENTE") ?></th>
            <th style="width: 10%;" class="text-center"><?php _e("EMAIL") ?></th>
            <th style="width: 10%;" class="text-center"><?php _e("CÉDULA/RUC") ?></th>
            <th style="width: 5%;" class="text-center"><?php _e("TELÉFONO") ?></th>
            <th style="width: 25%;" class="text-center"><?php _e("DIRECCION") ?></th>
            <th style="width: 20%;" class="text-center"></th>
        </tr>
    </thead>
    <?php
    if (!empty($lista_cliente)) {
        foreach ($lista_cliente as $key => $value) {  ?>
            <tr style="color:black;font-size:14px;">
                <td><?= $value->id; ?></td>
                <td><?= $value->nombre; ?></td>
                <td><?= $value->email; ?></td>
                <td><?= $value->dni_ruc; ?></td>
                <td><?= $value->telefono; ?></td>
                <td><?= $value->direccion; ?></td>
                <td class="text-center">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <form method="POST" action="#">
                                <button class="btn btn-warning" name="codigo_cliente" style="font-size:1em;" value="<?= $value->id; ?>"><i class="far fa-edit"></i></button>
                            </form>
                        </div>
                        <div class="form-group col-md-6">
                            <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                <input type='hidden' name='action' value='wrpoc-post-cliente'>
                                <input type='hidden' name='crud' id="crud" value='remove'>
                                <button class="btn btn-danger" style="font-size:1em;" name="eliminar_cliente" value="<?= $value->id; ?>" onclick="return validarDelete();"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
    <?php }
    } else {
        echo "No existen datos";
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
                <a onclick="wbct_buscar_informacion('<?= 1; ?>','clientes.php','<?= $codigo; ?>')">Inicio</a>
            </li>
            <?php if ($pagina > 1) { ?>
                <li class="page-item">
                    <a onclick="wbct_buscar_informacion('<?php echo $pagina - 1 ?>','clientes.php','<?= $codigo; ?>')">
                        <span aria-hidden="true">
                            << </span>
                    </a>
                </li>
            <?php } ?>
            <?php for ($i = $start_loop; $i <= $end_loop; $i++) { ?>
                <?php if ($i > 0) { ?>
                    <li>
                        <a class="<?php if ($i == $pagina) echo "wr-paginacion-active" ?>" onclick="wbct_buscar_informacion('<?php echo $i ?>','clientes.php','<?= $codigo; ?>')">
                            <?php echo $i ?></a>
                    </li>
            <?php }
            } ?>
            <?php if ($pagina < $end_loop) {  ?>
                <li>
                    <a onclick="wbct_buscar_informacion('<?php echo $pagina + 1 ?>','clientes.php','<?= $codigo; ?>')">
                        <span aria-hidden="true">>></span>
                    </a>
                </li>
                <li class="page-item">
                    <a onclick="wbct_buscar_informacion('<?= $paginas; ?>','clientes.php','<?= $codigo; ?>')">Ultima</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>