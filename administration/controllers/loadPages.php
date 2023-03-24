<?php

defined('ABSPATH') or die('');
require_once plugin_dir_path(__FILE__) . '../../library/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

class WBCT_LoadPageController
{
    function __construct()
    {
    }
    final function loadPage($page)
    {
        wp_enqueue_style(
            'wrpro_style_bootstrap',
            plugin_dir_url(__FILE__) . '../../static/plugins/bootstrap/css/bootstrap.min.css',
            array(),
            "1.0.0"
        );
        wp_enqueue_style(
            'wpro_style_interno',
            plugins_url('../../static/css/style.css', __FILE__)
        );
        wp_enqueue_script(
            'wpro_fontawasome',
            plugins_url('../../static/plugins/fontawasome/all.js', __FILE__),
            array('jquery')
        );



        if ($page == "clientes.php") {
            $operaciones_clientes = new WBCT_OperacionesClientes();
            $aux = isset($_POST['codigo_cliente']) ? "update" : "add";
            $actiu = isset($_POST['codigo_cliente']) ? "block" : "none";
            $actig = isset($_POST['codigo_cliente']) ? "none" : null;
            if (isset($_POST['codigo_cliente'])) {
                $buscar_cliente =  $operaciones_clientes->wr_pro_load_clientes($_POST['codigo_cliente']);
                foreach ($buscar_cliente as $value) {
                    $id = $value->id;
                    $nombre = $value->nombre;
                    $email = $value->email;
                    $dni_ruc = $value->dni_ruc;
                    $telf = $value->telefono;
                    $observa = $value->direccion;
                }
            }

            wp_enqueue_script(
                'wbct_js_interno',
                plugins_url('../../static/js/validation.js', __FILE__),
                array('jquery')
            );
            wp_enqueue_script(
                'wrpro_booststrap_js',
                plugins_url('../../static/plugins/bootstrap/js/bootstrap.min.js', __FILE__),
                array('jquery')
            );
            wp_enqueue_script(
                'wbct_js_paginacion',
                plugins_url('../../static/js/paginacion.js', __FILE__),
                array('jquery')
            );
            wp_localize_script(
                'wbct_js_paginacion',
                'SolicitudesAjax',
                [
                    'url' => admin_url('admin-ajax.php'), 'seguridad' => wp_create_nonce('seg')
                ]
            );
        } else if ($page == "cotizacion.php") {

            $titulo = esc_attr(get_option('_wb_data_imagen')['wbct_titulo']);
            $url_imagen = esc_attr(get_option('_wb_data_imagen')['wbct_logo']);

            $valor_iva = !empty(esc_attr(get_option('_wb_data_iva')['valor_iva'])) ? esc_attr(get_option('_wb_data_iva')['valor_iva']) : "0";
            $load_id_cotizacion = new WRPRO_Operaciones_proforma();

            $fecha__fin_proforma =  date('Y-m-d', strtotime(date("d-m-Y") . ' + 5 days'));
            $id_cliente = "";
            $codigo_proforma = "";
            $nombre_cliente = "";
            $email_cliente  = "";
            $dni_ruc_cliente   = "";
            $telf_cliente    = "";
            $observ_cliente   = "";
            $fecha_proforma = date("Y-m-d");
            $mensaje = "";
            $wrpro_estado = "";
            $ocultar_listar_proforma = "";
            $load_proforma = null;

            if (isset($_GET['id'])) {
                $codigo_proforma = $_GET['id'];
                $mensaje = "Editar Proforma";
                $aux = "update";
                $ocultar_cancelar_save = "none";
                $ocultar_cancelar_update = "block";
                $wrpro_estado = "";
                $ocultar_listar_proforma = "none";
                $id_proforma = $_GET['id'];
                $wrpro_load_datos = new  WBCT_database();
                $load_proforma = $wrpro_load_datos->wbct_buscar_proforma_id("wbct_cotizacion", $id_proforma);

                foreach ($load_proforma  as  $key => $row) {
                    $codigo_cotizacion = $row['id'];
                    $id_cliente = $row['id_cli'];
                    $subtotal_proforma =  $row['subtotal'];
                    $decuento = $row['descuento'];
                    $subtotal_desc = $row['subtotalall'];
                    $iva_proforma =  $row['iva'];
                    $total_proforma = $row['total'];
                    $terminos_condiciones = $row['terminos_condiciones'];
                }

                $load_cliente = $wrpro_load_datos->wbct_buscar_proforma_id("wbct_cliente",  $id_cliente);
                foreach ($load_cliente  as  $key => $row) {
                    $id_cliente = $row['id'];
                    $nombre_cliente = $row['nombre'];
                    $email_cliente  = $row['email'];
                    $dni_ruc_cliente   = $row['dni_ruc'];
                    $telf_cliente    = $row['telefono'];
                    $observ_cliente   = $row['direccion'];
                }

                $load_det_proforma = $wrpro_load_datos->wbct_buscar_detalle_id("wbct_detalle_cotizacion",  $_GET['id']);

            } else {
                $mensaje = "Generar Proforma";
                $ocultar_cancelar_save = "block";
                $ocultar_cancelar_update = "none";
                $aux = "add";
                $codigo_cotizacion =  $load_id_cotizacion->wrbct_retorn_maximo_id_cotizacion();
                $terminos_condiciones =  $load_id_cotizacion->wbct_cargar_terminos_condiciones();
            }

            wp_enqueue_script(
                'wbctJSnewCotizacion',
                plugins_url('../../static/js/jsCotizacion.js', __FILE__),
                array('jquery')
            );

            wp_localize_script(
                'wbctJSnewCotizacion',
                'SolicitudesAjax',
                ['url' => admin_url('admin-ajax.php'), 'seguridad' => wp_create_nonce('seg')]
            );
            wp_enqueue_script(
                'wbct_jquery-ui',
                plugins_url('../../static/plugins/jquery-ui/jquery-ui.js', __FILE__),
                array('jquery')
            );
        } else if ($page == "producto.php") {
            $boton_editar = "none";
            $boton_registrar = "block";
            $aux = "add";
            $cargar_producto = new WBCT_OperacionesProducto;
            if (isset($_POST['codigo_producto'])) {
                $boton_editar  = "block";
                $boton_registrar = "none";
                $dato = $_POST['codigo_producto'];
                $buscar_producto = $cargar_producto->wbct_load_producto($dato);
                foreach ($buscar_producto as $key => $value) {
                    $id_producto = $value->id;
                    $nombre_producto = $value->producto;
                    $descrip_producto = $value->descripcion;
                    $precio_producto = $value->precio;
                }
                $aux = "update";
            }

            wp_enqueue_script(
                'wbctJSinterno',
                plugins_url('../../static/js/validation.js', __FILE__),
                array('jquery')
            );
            wp_enqueue_script(
                'wrpro_booststrap_js',
                plugins_url('../../static/plugins/bootstrap/js/bootstrap.min.js', __FILE__),
                array('jquery')
            );
            wp_enqueue_script(
                'wbct_js_paginacion',
                plugins_url('../../static/js/paginacion.js', __FILE__),
                array('jquery')
            );
            wp_localize_script(
                'wbct_js_paginacion',
                'SolicitudesAjax',
                [
                    'url' => admin_url('admin-ajax.php'), 'seguridad' => wp_create_nonce('seg')
                ]
            );
        } else if ($page == "inicio.php") {

            wp_enqueue_script(
                'wbctJSinterno',
                plugins_url('../../static/js/validation.js', __FILE__),
                array('jquery')
            );

            wp_enqueue_script(
                'wbctBooststrap_js',
                plugins_url('../../static/plugins/bootstrap/js/bootstrap.min.js', __FILE__),
                array('jquery')
            );

            wp_enqueue_script(
                'wpctJSpaginacion',
                plugins_url('../../static/js/paginacion.js', __FILE__),
                array('jquery')
            );

            wp_localize_script(
                'wpctJSpaginacion',
                'SolicitudesAjax',
                [
                    'url' => admin_url('admin-ajax.php'), 'seguridad' => wp_create_nonce('seg')
                ]
            );

            $url_imagen = esc_attr(get_option('_wb_data_imagen')['wbct_logo']);
        } else if ($page == "configuracion.php") {
            wp_enqueue_script(
                'wbcotizacion_booststrap_js',
                plugins_url('../../static/plugins/bootstrap/js/bootstrap.min.js', __FILE__),
                array('jquery')
            );

            wp_enqueue_script(
                'wbcotizaconJSimagen',
                plugins_url('../../static/js/jsimagen.js', __FILE__),
                array('jquery')
            );
            $titulo = esc_attr(get_option('_wb_data_imagen')['wbct_titulo']);
            $url_imagen = esc_attr(get_option('_wb_data_imagen')['wbct_logo']);
            $terminos_condiciones = esc_attr(get_option('_wb_data_condiciones')['datos_condiciones']);
            $valor_iva =  esc_attr(get_option('_wb_data_iva')['valor_iva']);
        } 
        require_once plugin_dir_path(__FILE__) . '../views/' . $page;
    }

    final function wrpro_presenta_mensaje()
    {
        if (isset($_SESSION["wrpro_mensaje"])) {
            echo ('<div class="alert alert-' . ($_SESSION['wrpro_mensaje']['status']) . '">    
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>' . __('Aviso:') . '</strong> ' . esc_attr($_SESSION["wrpro_mensaje"]['response']) . '
            </div>');
            $_SESSION["wrpro_mensaje"] = null;
        }
    }


    function imprimir_cotizacion($codigoCotizacion)
    {
       $nombreCotizacion = "Cotizacion-".$codigoCotizacion;
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/reporte.php';
        $html = ob_get_clean();
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
       // $paper_size = array(0, 0,360, 360); 
        $dompdf->setPaper('portrait');
       // $dompdf->setPaper($paper_size);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream($nombreCotizacion, array("Attachment" => 0));
    }
}
