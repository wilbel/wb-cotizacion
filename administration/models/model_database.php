<?php
class WBCT_database
{
    private $wpdb_local;
    function __construct()
    {
        global $wpdb;
        $this->wpdb_local = $wpdb;
    }
    public function wbct_createTable()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        //tabla clientes
        $tableClientes = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wbct_cliente(
            `id` int NOT NULL AUTO_INCREMENT,
            `nombre` text NOT NULL,
            `email` varchar(50) NOT NULL,
            `dni_ruc` varchar(13) NOT NULL,
            `telefono` varchar(12) NOT NULL,
            `direccion` text NOT NULL,
            PRIMARY KEY (`id`)
            )$charset_collate;";

        //tabla productos
        $tableProductos = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wbct_producto(
            `id` int(11) NOT NULL AUTO_INCREMENT,
               `producto` text NOT NULL,
               `descripcion` text NOT NULL,
               `precio` double NOT NULL,
           PRIMARY KEY (`id`)
           )$charset_collate;";


        //tabla proforma
        $tablaCotizacion = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wbct_cotizacion(
            `id` int(11) NOT NULL AUTO_INCREMENT,
               `fecha` date NOT NULL,
               `fecha_fin` date NOT NULL,
               `id_cli` int(11) NOT NULL,
               `subtotal` double NOT NULL,
               `descuento` double NOT NULL,
               `iva` double NOT NULL,             
               `subtotalall` double NOT NULL,
               `total` double NOT NULL,
               `terminos_condiciones` text  NULL,
                FOREIGN KEY (`id_cli`) REFERENCES {$wpdb->prefix}wbct_cliente(`id`),
                PRIMARY KEY (`id`)
                )$charset_collate;";


        //tabla detalle proforma
        $tablaDetalle = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wbct_detalle_cotizacion(
               `id` int(11) NOT NULL AUTO_INCREMENT,
               `id_cotizacion` int(11) NOT NULL,
               `cant_item` int(11) NOT NULL,
               `codigo_producto` int(11) NOT NULL,
               `prec_unit` double NOT NULL,
               `subtotal` double NOT NULL,
               FOREIGN KEY (`id_cotizacion`) REFERENCES {$wpdb->prefix}wbct_cotizacion(`id`),
               FOREIGN KEY (`codigo_producto`) REFERENCES {$wpdb->prefix}wbct_producto(`id`),
               PRIMARY KEY (`id`)
               )$charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($tableClientes);
        dbDelta($tableProductos);
        dbDelta($tablaCotizacion);
        dbDelta($tablaDetalle);
    }

    //registrar datos
    function wbct_agregar_datos_bd($tabla, $datos)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        return $this->wpdb_local->insert($tabla, $datos);
    }
    //Modificar regitros
    function wbct_modificar_bd($tabla, $datos, $where)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        return $this->wpdb_local->update($tabla, $datos, $where);;
    }
    //Eliminar registros
    function wbct_eliminar_bd($tabla, $where)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        return $this->wpdb_local->delete($tabla, $where);
    }
    //cargar datos
    function wbct_listar_bd($tabla)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        return $this->wpdb_local->get_results('SELECT * FROM ' . $tabla . '', ARRAY_A);
    }
    function wbct_listar_bd_id($tabla, $where = "")
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        return $this->wpdb_local->get_results('SELECT * FROM ' . $tabla . ' ' . $where . ';');
    }
    //Maximo id
    function wbct_maximo_id($tabla, $id)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        $query = "SELECT id FROM $tabla ORDER BY id DESC limit 1";
        $resultado = $this->wpdb_local->get_results($query, ARRAY_A);

        if (!empty($resultado) && is_array($resultado) && isset($resultado[0]['id'])) {
            return   $resultado[0]['id'];
        } else {
            return null;
        }
    }



    //Redireccionar paginas
    final function wbct_admin_redireccionamiento($argumento = "")
    {
        ob_start();
        $url_redirect = (empty(admin_url()) ? network_admin_url($argumento) : admin_url($argumento));
        wp_redirect($url_redirect);
        exit;
    }

    final function wbctEnviaMensaje($mensaje, $status)
    {
        $_SESSION["wbct_mensaje"] = array('response' => $mensaje, 'status' => $status);
    }

    final function wbct_envia_id_proforma($id)
    {
        $_SESSION[" wrpro_id"] = array('response' => $id, 'status' => $id);
    }

    function wbct_count_bd($tabla, $where)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        $sql = "SELECT count(*) as contador FROM $tabla $where";
        $resultado = $this->wpdb_local->get_results($sql);
        return $resultado != null ? $resultado[0]->contador : 0;
    }
    // Buscar tablas multiples
    function wbct_tables_multiple($tabla, $tabla1, $datos, $where)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        $tabla1 = $this->wpdb_local->prefix . $tabla1;
        $sql = "SELECT $datos FROM $tabla , $tabla1  $where";
        return  $this->wpdb_local->get_results($sql);
    }
    //numracion de la proforma
    function  wbct_agregar_numeracion_cotizacion($tabla, $datos)
    {
        $tabla_proforma  = $this->wpdb_local->prefix . $tabla;
        $sql_autoincrementable = " ALTER TABLE $tabla_proforma AUTO_INCREMENT = $datos";
        return   $this->wpdb_local->query($sql_autoincrementable);
    }
    //seleccionar el autoincrementable
    function wbct_obtener_autoincrementable($tabla)
    {
        $tabla_proforma  = $this->wpdb_local->prefix . $tabla;
        $sql_autoincrementable = " SELECT AUTO_INCREMENT FROM  $tabla_proforma ";
        return   $this->wpdb_local->query($sql_autoincrementable);
    }
    //Transaccion sql
    function wbct_query_bd($comando)
    { //Transaccion sql
        $this->wpdb_local->query($comando);
    }
    //cargar campos de autocompletar
    function  wbct_cargar_datos_autocompletar($tabla, $identificador, $buscador)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        $sql = "SELECT * FROM $tabla where $identificador like '%" . $buscador . "%' LIMIT 0 ,10";
        $wrpro_devolver_datos = $this->wpdb_local->get_results($sql, ARRAY_A);
        return $wrpro_devolver_datos;
    }
    //buscar proforma
    function wbct_buscar_proforma_id($tabla, $id_proforma)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        $sql = "SELECT * FROM $tabla  WHERE  $tabla.id = $id_proforma";
        $wrpro_devolver_datos = $this->wpdb_local->get_results($sql);
        return   $wrpro_devolver_datos;
    }
    //encontrar detalle del producto
    function wbct_buscar_detalle_id($tabla, $id_proforma)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        $sql = "SELECT * FROM $tabla  WHERE  $tabla.id_cotizacion = $id_proforma";
        $wrpro_devolver_datos = $this->wpdb_local->get_results($sql);
        return   $wrpro_devolver_datos;
    }
    //retornar un dato de una tabla especifica mediante el id
    function wbct_retornar_nombre_producto($tabla, $id)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        $sql = "SELECT $tabla.producto FROM $tabla  WHERE  $tabla.id = $id";
        $wrpro_devolver_datos = $this->wpdb_local->get_results($sql, ARRAY_A);
        foreach ($wrpro_devolver_datos  as  $key => $row) {
            $nombre_producto = $row['producto'];
        }
        return   $nombre_producto;
    }

    function wbct_retornar_descripcion_producto($tabla, $id)
    {
        $tabla = $this->wpdb_local->prefix . $tabla;
        $sql = "SELECT $tabla.descripcion FROM $tabla  WHERE  $tabla.id = $id";
        $wrpro_devolver_datos = $this->wpdb_local->get_results($sql, ARRAY_A);
        foreach ($wrpro_devolver_datos  as  $key => $row) {
            $descripcion_producto = $row['descripcion'];
        }
        return   $descripcion_producto;
    }

    function wbct_get_prefijo_table()
    {
        return $this->wpdb_local->prefix;
    }

    function wbct_load_detalles_factura($tbproducto, $tbdetalle, $idproforma)
    {
        $tbproducto = $this->wpdb_local->prefix . $tbproducto;
        $tbdetalle = $this->wpdb_local->prefix . $tbdetalle;
        $sql = "SELECT id_cotizacion,cant_item,codigo_producto,prec_unit,subtotal,
        $tbproducto.id,$tbproducto.producto, $tbproducto.descripcion FROM $tbdetalle,$tbproducto
        WHERE  id_cotizacion = $idproforma AND $tbproducto.id=$tbdetalle.codigo_producto";
        return  $this->wpdb_local->get_results($sql);
    }
}
