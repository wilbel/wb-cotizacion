<?php
add_action('admin_menu', 'wbct_menu_admin');
function wbct_menu_admin()
{
    add_menu_page(
        'Cotizacion',
        'Cotizacion',
        'wb_cotizacion',
        'wbct_menu',
        'wbct_subemnu_mostrarContenido',
        plugin_dir_url(__FILE__) . '../static/imagenes/proforma.png',
        '8'
    );
    add_submenu_page('wbct_menu', 'listaCotizacion', 'Crear Cotizacion', 'wb_cotizacion', 'wbct_menu_cotizacion', 'wbctSubmenuCotizacion');
    add_submenu_page('wbct_menu', 'Cliente', 'Clientes', 'wb_cotizacion', 'wbct_menu_clientes', 'wbct_submenuCliente');
    add_submenu_page('wbct_menu', 'producto', 'Productos', 'wb_cotizacion', 'wbct_menu_producto', 'wbct_submenuProducto');
    //  add_submenu_page(null, 'reportes', 'reportes', 'wb_cotizacion', 'wrpro_menu_reportes', 'wrpro_submenuProformas_reportes');
    add_submenu_page('wbct_menu', 'Configuracion', 'Configuración', 'wb_cotizacion', 'wbct_menu_configuracion', 'wbct_submenuProformas_configuracion');
}
//configuraciones
function wbct_submenuProformas_configuracion()
{
    $load_page = new WBCT_LoadPageController();
    $load_page->loadPage("configuracion.php");
}

function wbctSubmenuCotizacion()
{
    $load_page = new WBCT_LoadPageController();
    $load_page->loadPage("cotizacion.php");
}

function wbct_subemnu_mostrarContenido()
{
    $load_page = new WBCT_LoadPageController();
    $load_page->loadPage("inicio.php");
}
function wbct_submenuCliente()
{
    $load_page = new WBCT_LoadPageController();
    $load_page->loadPage("clientes.php");
}

function wbct_submenuProducto()
{
    $load_page = new WBCT_LoadPageController();
    $load_page->loadPage("producto.php");
}

function wbct_submenuProformas_reportes()
{
    $load_page = new WBCT_LoadPageController();
    $load_page->loadPage("reportes.php");
}
//Registrar Clientes
add_action('admin_post_wrpoc-post-cliente', 'wrpoc_post_cliente');
function wrpoc_post_cliente()
{
    $cliente = new WBCT_OperacionesClientes;
    $cliente->wrpoc_admin_cliente();
}

add_action('admin_post_wbct-oper-producto', 'wbct_operacionProducto');

function wbct_operacionProducto()
{
    $producto = new WBCT_OperacionesProducto();
    $producto->wbct_admin_producto();
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
add_action('admin_post_wbct_configuraciones', 'wbctConfiguraciones');
function wbctConfiguraciones()
{
    $configuraciones = new WBCT_OperacionesConfiguraciones();
    $configuraciones->wbct_configuracion_cotizacion();
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
function wbct_buscarCliente()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'seg')) {
        die('no tiene permisos para ejecutar ese ajax');
    }
    $sql_tablas = new WBCT_database();
    $cliente_autocomp = $sql_tablas->wbct_cargar_datos_autocompletar("wbct_cliente", "nombre", ($_POST['term']));
    $return_arr = array();
    foreach ($cliente_autocomp  as  $key => $row) {
        $id_cliente = $row['id'];
        $row_array['value'] = $row['nombre'];
        $row_array['id_cliente'] = $id_cliente;
        $row_array['email_cliente'] = $row['email'];
        $row_array['dni_ruc_cliente'] = $row['dni_ruc'];
        $row_array['telefono_cliente'] = $row['telefono'];
        $row_array['direccion_cliente'] = $row['direccion'];
        array_push($return_arr, $row_array);
    }
    wp_reset_postdata();
    wp_send_json($return_arr);
}
add_action('wp_ajax_wbct_buscar_cliente', 'wbct_buscarCliente');
//PAGINACION
add_action('wp_ajax_wrpro_load_informacion', 'wrpro_load_informacion');
function wrpro_load_informacion()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'seg')) {
        die('no tiene permisos para ejecutar ese ajax');
    }
    $nombre_pagina = ($_POST["nombre_pagina"]);
    if ($nombre_pagina == 'inicio.php') {
        require_once plugin_dir_path(__FILE__) . 'paginacion/paginacion_cotizaciones.php';
    } else if ($nombre_pagina == 'producto.php') {
        require_once plugin_dir_path(__FILE__) . 'paginacion/paginacion_productos.php';
    } else if ($nombre_pagina == 'clientes.php') {
        require_once plugin_dir_path(__FILE__) . 'paginacion/paginacion_clientes.php';
    }
    wp_die();
}
