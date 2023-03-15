<?php
add_action('admin_menu', 'wrpro_menu_admin');
function wrpro_menu_admin()
{
    add_menu_page(
        'Proforma',
        'Proformas',
        'wr_proforma',
        'wrpro_menu',
        'wrpro_subemnu_mostrarContenido',
        plugin_dir_url(__FILE__) . '../static/imagenes/proforma.png',
        '2'
    );
    add_submenu_page('wrpro_menu', 'listProformas', 'Crear Proforma', 'wr_proforma', 'wrpro_menu_listproforma', 'wrpro_submenuProformas');
    add_submenu_page('wrpro_menu', 'Cliente', 'Clientes', 'wr_proforma', 'wrpro_menu_clientes', 'wrpro_submenuCliente');
    add_submenu_page('wrpro_menu', 'producto', 'Productos', 'wr_proforma', 'wrpro_menu_producto', 'wrpro_submenuProducto');
    add_submenu_page(null, 'reportes', 'reportes', 'wr_proforma', 'wrpro_menu_reportes', 'wrpro_submenuProformas_reportes');
    add_submenu_page('wrpro_menu', 'Configuracion', 'Configuración', 'wr_proforma', 'wrpro_menu_configuracion', 'wrpro_submenuProformas_configuracion');
}
//configuraciones
function wrpro_submenuProformas_configuracion()
{
    $wrpro = new WRPRO_AdminLoad_PageController();
    $wrpro->wrpro_load_page("configuracion.phtml");
}

function wrpro_submenuProformas()
{
    $wrpro = new WRPRO_AdminLoad_PageController();
    $wrpro->wrpro_load_page("proforma.phtml");
}

function wrpro_subemnu_mostrarContenido()
{
    $wrpro = new WRPRO_AdminLoad_PageController();
    $wrpro->wrpro_load_page("inicio.phtml");
}
function wrpro_submenuCliente()
{
    $wrpro = new WRPRO_AdminLoad_PageController();
    $wrpro->wrpro_load_page("clientes.phtml");
}

function wrpro_submenuProducto()
{
    $wrpro = new WRPRO_AdminLoad_PageController();
    $wrpro->wrpro_load_page("producto.phtml");
}

function wrpro_submenuProformas_reportes()
{
    $wrpro = new WRPRO_AdminLoad_PageController();
    $wrpro->wrpro_load_page("reportes.phtml");
}
//Registrar Clientes
add_action('admin_post_wrpoc-post-cliente', 'wrpoc_post_cliente');
function wrpoc_post_cliente()
{
    $cliente = new WRPRO_Operaciones_clientes;
    $cliente->wrpoc_admin_cliente();
}

add_action('admin_post_wrpoc-post-producto', 'wrpro_oper_producto');

function wrpro_oper_producto()
{
    $producto = new WRPRO_Operaciones_producto;
    $producto->wrpro_admin_producto();
}
//Proforma
add_action('admin_post_wrpro-pro-proforma', 'wrpro_post_proforma');
function wrpro_post_proforma()
{
    $proforma = new WRPRO_Operaciones_proforma;
    $proforma->wrpro_admin_proforma();
}
//Reporte semanales, trimestrales  VERFICAR
add_action('admin_post_wrpro-imprimir-reporte', 'wrpro_post_imprimir_reporte');
function wrpro_post_imprimir_reporte()
{
    $fecha_inicio = ($_POST['fecha_inicio']);
    $fecha_fin = ($_POST['fecha_fin']);
    $reporte = new wrpro_imprimir_reportes();
    $reporte->wrpro_admin_reportes($fecha_inicio, $fecha_fin);
}
//Configuraciones de iva y descuento
add_action('admin_post_wrpro_configuraciones', 'wrpro_configuraciones');
function wrpro_configuraciones()
{
    $configuraciones = new WRPRO_Operaciones_configuraciones();
    $configuraciones->wrpro_configuracion_proforma();
}

//registrar producto
function wrpro_registrarProducto()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'seg')) {
        die('no tiene permisos para ejecutar ese ajax');
    }
    $sql_tablas = new WRPRO_database();
    $prod =  sanitize_text_field($_POST['nom_prod']);
    $descrip = preg_replace('/\<br(\s*)?\/?\>/i', "\n", ($_POST['descripcion'])); //text area
    $precio =  sanitize_text_field($_POST['precio']);
    $datos = ['id' => null, 'prod' => $prod, 'descrip' => $descrip, 'precio' => $precio];
    $sql_tablas->wrpro_agregar_datos_bd("wrpro_producto", $datos);
    $proximoId = $sql_tablas->wrpro_maximo_id("wrpro_producto", "");
    wp_send_json($proximoId);
    return true;
}
add_action('wp_ajax_wrpro_peticionRegistrar', 'wrpro_registrarProducto');

//Buscar Productos
function wrpro_buscar_producto()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'seg')) {
        die('no tiene permisos para ejecutar ese ajax');
    }
    $sql_tablas = new WRPRO_database();
    $productos_autocomp = $sql_tablas->wrpro_cargar_datos_autocompletar("wrpro_producto", "prod", ($_POST['term']));
    $return_arr = array();
    foreach ($productos_autocomp   as  $key => $row) {
        $id_prod = $row['id'];
        $row_array['value'] = $row['prod'];
        $row_array['id_pro'] = $id_prod;
        $row_array['descrip'] = $row['descrip'];
        $row_array['precio'] = $row['precio'];
        array_push($return_arr, $row_array);
    }
    wp_reset_postdata();
    wp_send_json($return_arr);
}
add_action('wp_ajax_wrpro_buscar_producto', 'wrpro_buscar_producto');
//Imprimir reporte
add_action('admin_post_wrpro-imprimir-proforma', 'wrpro_post_imprimir_proforma');
function wrpro_post_imprimir_proforma()
{
    $id_proforma = ($_POST['id_proforma']);
    $reporte = new wrpro_imprimir_proformas;
    $reporte->wrpro_admin_proforma($id_proforma);
}
//Buscar clientes
function wrpro_buscar_cliente()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'seg')) {
        die('no tiene permisos para ejecutar ese ajax');
    }
    $sql_tablas = new WRPRO_database();
    $cliente_autocomp = $sql_tablas->wrpro_cargar_datos_autocompletar("wrpro_cliente", "nom", ($_POST['term']));
    $return_arr = array();
    foreach ($cliente_autocomp  as  $key => $row) {
        $id_cliente = $row['id'];
        $row_array['value'] = $row['nom'];
        $row_array['id_cliente'] = $id_cliente;
        $row_array['email_cliente'] = $row['email'];
        $row_array['dni_ruc_cliente'] = $row['dni_ruc'];
        $row_array['telefono_cliente'] = $row['telf'];
        $row_array['direccion_cliente'] = $row['observ'];
        array_push($return_arr, $row_array);
    }
    wp_reset_postdata();
    wp_send_json($return_arr);
}
add_action('wp_ajax_wrpro_buscar_cliente', 'wrpro_buscar_cliente');
//PAGINACION
add_action('wp_ajax_wrpro_load_informacion', 'wrpro_load_informacion');
function wrpro_load_informacion()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'seg')) {
        die('no tiene permisos para ejecutar ese ajax');
    }
    $nombre_pagina = ($_POST["nombre_pagina"]);
    if ($nombre_pagina == 'inicio.phtml') {
        require_once plugin_dir_path(__FILE__) . 'paginacion/paginacion_proformas.phtml';
    } else if ($nombre_pagina == 'producto.phtml') {
        require_once plugin_dir_path(__FILE__) . 'paginacion/paginacion_productos.phtml';
    } else if ($nombre_pagina == 'clientes.phtml') {
        require_once plugin_dir_path(__FILE__) . 'paginacion/paginacion_clientes.phtml';
    }
    wp_die();
}
