<?php

/**
 * Plugin Name: WR-Proformas 
 * Plugin URI: https://www.webrevolutionagency.com/
 * Description: Este plugin permite generar proformas 
 * Version: 1.8.4
 * Author: Web Revolution Milano
 * Author https://www.webrevolutionagency.com/
 * License: GPL2
 * Text Domain: wr-Proforma
 * Domain Path: /languages
 */

require_once dirname(__FILE__) . '/administration/models/wpro-bd.php'; //llamar a la clase base de datos

function wrpro_activar()
{
    $basedatos = new WRPRO_database;
    $basedatos->wrpro_database();
}

//Aniadir rol y capacidad

register_activation_hook(__FILE__, 'add_cliente_proforma_role');


function add_cliente_proforma_role()
{
    remove_role('proformas_clientes');
    $role = get_role('administrator');
    $role->add_cap('wr_proforma', true);
    add_role(
        'proformas_clientes',
        __('Proformas clientes', 'add-proformas-clientes-role'),
        array(
            'wr_proforma' => true,
            'manage_options' => false,
            'read' => true
        )
    );
}


register_activation_hook(__FILE__, 'wrpro_activar');

if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'administration/controllers/wrpro_cargar_paginas.php';
    require_once plugin_dir_path(__FILE__) . 'administration/wrpro-hooks.php';
    require_once plugin_dir_path(__FILE__) . 'administration/controllers/wrpro-oper_clientes.php';
    require_once plugin_dir_path(__FILE__) . 'administration/controllers/wrpro-oper_productos.php';
    require_once plugin_dir_path(__FILE__) . 'administration/controllers/wrpro-oper_proforma.php';
    require_once plugin_dir_path(__FILE__) . 'administration/controllers/wrpro_rep_proforma.php';
    require_once plugin_dir_path(__FILE__) . 'administration/controllers/wrpro_reportes_fechas.php';

    require_once plugin_dir_path(__FILE__) . 'administration/controllers/Configuracion.php';



    require_once plugin_dir_path(__FILE__) . 'library/fpdf/fpdf.php';
}

function wrpro_session()
{
    if (!session_id() && is_user_logged_in()) {
        session_start();
    }
}
add_action('init', 'wrpro_session', 1);
