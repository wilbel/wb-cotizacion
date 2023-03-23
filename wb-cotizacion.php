<?php

/**
 * Plugin Name: WR-Cotizacion 
 * Plugin URI: https://www.wibcode.com/
 * Description: Crear cotizaciones para las empresas, dando mejor servicio a los clientes.
 * Version: 1.0.0
 * Author: Wibcode
 * Author https://www.wibcode.com/
 * License: GPL2
 * Text Domain: wr-cotizacion
 * Domain Path: /languages
 */

require_once dirname(__FILE__) . '/administration/models/model_database.php'; //llamar a la clase base de datos

function wbct_activar()
{
    $basedatos = new WBCT_database();
    $basedatos->wbct_createTable();
}

register_activation_hook(__FILE__, 'wbct_activar');
//Aniadir rol y capacidad

function add_cliente_proforma_role()
{
    remove_role('cotizacion_clientes');
    $role = get_role('administrator');
    $role->add_cap('wb_cotizacion', true);
    add_role(
        'cotizacion_clientes',
        __('Cotizacion clientes', 'add-cotizacion-clientes-role'),
        array(
            'wb_cotizacion' => true,
            'manage_options' => false,
            'read' => true
        )
    );
}

register_activation_hook(__FILE__, 'add_cliente_proforma_role');

if (is_admin()) {
    
    require_once plugin_dir_path(__FILE__) . 'administration/controllers/loadPages.php';
    require_once plugin_dir_path(__FILE__) . 'administration/wbctHook.php';
    require_once plugin_dir_path(__FILE__) . 'administration/controllers/operacionesClientes.php';
    require_once plugin_dir_path(__FILE__) . 'administration/controllers/operacionesProductos.php';
    require_once plugin_dir_path(__FILE__) . 'administration/controllers/operacionCotizacion.php';
    
    require_once plugin_dir_path(__FILE__) . 'administration/controllers/wrpro_rep_proforma.php';
   /* require_once plugin_dir_path(__FILE__) . 'administration/controllers/wrpro_reportes_fechas.php';*/

    require_once plugin_dir_path(__FILE__) . 'administration/controllers/operacionesConfiguracion.php';
    require_once plugin_dir_path(__FILE__) . 'library/fpdf/fpdf.php';
}

function wbct_session()
{
    if (!session_id() && is_user_logged_in()) {
        session_start();
    }
}
add_action('init', 'wbct_session', 1);
