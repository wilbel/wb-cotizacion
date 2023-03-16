<?php
define('CANT_ITEMS_BY_PAGE', 10);
$querys = new WBCT_database();
$dato_search = !empty($_POST["dato_search"]) ? $_POST["dato_search"] : '';
$pagina = !empty($_POST["pagina"]) ? $_POST["pagina"] : 1;
$limit = CANT_ITEMS_BY_PAGE;
$offset = ($pagina - 1) * CANT_ITEMS_BY_PAGE;
global $wpdb;
$codigo = $_POST['codigo'];
$conteo = $querys->wrpro_count_bd('wbct_producto', '');
$paginas = ceil($conteo / CANT_ITEMS_BY_PAGE); //cantidad de bloques
$datos_busquedad =  ' CONCAT(' . $wpdb->prefix . 'wbct_producto.id," ",producto," ",descripcion," ",precio) LIKE "%' . $dato_search . '%"';
$cargar_productos = $querys->wrpro_listar_bd_id('wbct_producto', ' WHERE ' . $datos_busquedad . ' ORDER BY producto DESC LIMIT ' . $limit . ' OFFSET ' . $offset); ?>

<table class="table-responsive table table-striped" id="iptable" style="font-size:12px;">
    <thead style="background-color:#D6DBDF ;color:black;font-weight: bold;">
        <tr>
            <th style="width: 10%;" class="text-center"><?php _e('NOMBRE PRODUCTO') ?>  </th>
            <th style="width: 10%;" class="text-center"><?php _e('DESCRIPCIÓN') ?></th>
            <th style="width: 10%;" class="text-center"><?php _e('PRECIO') ?></th>
            <th style="width: 10%;" class="text-center"></th>
        </tr>
    </thead>
    <?php

    if (!empty($cargar_productos)) {
        foreach ($cargar_productos as $key => $value) {  ?>
            <tr style="color:black;font-size:14px;">
                <td class="text-center"> <?= $value->producto;  ?> </td>
                <td class="text-center" style="width: 35%;"><?= $value->descripcion; ?></td>
                <td class="text-center"><?= $value->precio; ?></td>
                <td class="text-center" style="width: 15%;">
                    <div class="row">
                        <div class="form-group col-sm-5">
                            <form method="POST" action="#">
                                <button class="btn btn-warning" name="codigo_producto" style="font-size:1em;" value="<?= $value->id; ?>"><i class="far fa-edit"></i></button>
                            </form>
                        </div>
                        <div class="form-group col-sm-5">
                            <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                <input type='hidden' name='action' value='wrpoc-post-producto'>
                                <input type='hidden' name='crud' id="crud" value='remove'>
                                <button class="btn btn-danger" style="font-size:1em;" name="eliminar_producto" value="<?= $value->id; ?>" onclick="return validarDelete();"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
    <?php }
    } else {
        echo "<tr><td class='text-center' colspan='4'>" . __('No existen datos') . "</td></tr>";
    } ?>
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
                <a onclick="wrpro_buscar_informacion('<?= 1; ?>','producto.phtml','<?= $codigo; ?>')">Inicio</a>
            </li>
            <?php if ($pagina > 1) { ?>
                <li class="page-item">
                    <a onclick="wrpro_buscar_informacion('<?php echo $pagina - 1 ?>','producto.phtml','<?= $codigo; ?>')">
                        <span aria-hidden="true">
                            << </span>
                    </a>
                </li>
            <?php } ?>
            <?php for ($i = $start_loop; $i <= $end_loop; $i++) { ?>
                <?php if ($i > 0) { ?>
                    <li>
                        <a class="<?php if ($i == $pagina) echo "wr-paginacion-active" ?>" onclick="wrpro_buscar_informacion('<?php echo $i ?>','producto.phtml','<?= $codigo; ?>')">
                            <?php echo $i ?></a>
                    </li>
            <?php }
            } ?>
            <?php if ($pagina < $end_loop) {  ?>
                <li>
                    <a onclick="wrpro_buscar_informacion('<?php echo $pagina + 1 ?>','producto.phtml','<?= $codigo; ?>')">
                        <span aria-hidden="true">>></span>
                    </a>
                </li>
                <li class="page-item">
                    <a onclick="wrpro_buscar_informacion('<?= $paginas; ?>','producto.phtml','<?= $codigo; ?>')">Ultima</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>