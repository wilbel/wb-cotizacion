<?php

class WRPRO_Operaciones_proforma extends WRPRO_database
{

    function __construct()
    {
        parent::__construct();
    }
    //Insertar Proforma
    private function wrpro_agregar_proforma()
    {
        $codigo_cliente = sanitize_text_field($_POST['id_cliente']);
        if (empty($_POST['id_cliente'])) {
            $codigo_cliente = $this->wrpro_Save_cliente();
        }

        $this->wrpro_query_bd('START TRANSACTION'); //COMIEZA TRANSACCION 

        if (!($_POST['total_all']) == 0) {
            $fecha_proforma = sanitize_text_field($_POST['fecha_ini']);
            $fecha_fin = sanitize_text_field($_POST['fecha_fin']);
            $id_cliente = $codigo_cliente;
            $iva = sanitize_text_field($_POST['iva']);
            $subtotalpr = sanitize_text_field($_POST['subtotalall']);
            $total = sanitize_text_field($_POST['total_all']);

            $descuento = sanitize_text_field($_POST['wr_descuento']);
            $subtotal_descuento = sanitize_text_field($_POST['wr_subt_desc']);

            $texto_terminos_condiciones = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $_POST['txtarea_tercond']);
            //detalle proforma
            $cantidad_producto = ($_POST['cantidad']);
            $prec_unit = ($_POST['precio_venta']);
            /**Datos del producto */
            $nombre_producto = ($_POST['articulo']);
            $descripcion_producto = ($_POST['descrip_prod']);
            //Insertar proforma
            $datos = ['fecha' => $fecha_proforma, 'fecha_fin' => $fecha_fin, 'id_cli' => $id_cliente, 'subtotal' => $subtotalpr, 'descuento' => $descuento, 'iva' => $iva, 'subtotalall' => $subtotal_descuento, 'total' => $total, 'terminos_condiciones' => $texto_terminos_condiciones];
            $respuesta = $this->wrpro_agregar_datos_bd("wrpro_proforma", $datos);
            $proximoId = $this->wrpro_maximo_id("wrpro_proforma", "id"); //agregar termino condicion

            if ($respuesta) {
                $i = 0;
                while ($i < count($cantidad_producto)) {
                    $datos_producto = ['id' => null, 'prod' => trim($nombre_producto[$i]), 'descrip' => trim($descripcion_producto[$i]), 'precio' => $prec_unit[$i]];
                    $this->wrpro_agregar_datos_bd("wrpro_producto",  $datos_producto);
                    $cod_producto = $this->wrpro_maximo_id("wrpro_producto", "id");
                    $subtotall = ($cantidad_producto[$i]) * ($prec_unit[$i]);
                    $datos_detalle = ['id_prof' => $proximoId, 'cant_item' => $cantidad_producto[$i], 'cod_prod' => $cod_producto, 'prec_unit' => $prec_unit[$i], 'subtotal' => $subtotall];
                    $this->wrpro_agregar_datos_bd("wrpro_det_proforma", $datos_detalle);
                    $i++;
                }
                $this->wrpro_query_bd('COMMIT');
                $this->wrpro_envia_mensaje(__("Proforma se registro correctamente"), "success");
            } else {
                $this->wrpro_query_bd('ROLLBACK');
                $this->wrpro_envia_mensaje(__("Error al registrar datos"), "danger");
            }
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu");
        } else {

            $this->wrpro_envia_mensaje(__("Error al registrar datos"), "danger");
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu");
        }
    }

    //ELiminar proforma

    private function wrpro_eliminar_proforma()
    {
        if (isset($_POST['eliminar_proforma']) && !empty($_POST['eliminar_proforma'])) {
            $id_proforma = $_POST['eliminar_proforma'];
            $this->wrpro_eliminar_bd("wrpro_det_proforma", array("id_prof" => $id_proforma));
            $this->wrpro_eliminar_bd("wrpro_proforma", array("id" => $id_proforma));
            $this->wrpro_envia_mensaje(__("Proforma eliminada correctamente"), "success");
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu");
        } else {
            $this->wrpro_envia_mensaje(__("Error al eliminar proforma"), "danger");
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu");
        }
    } //fin eliminar proforma

    function wrpro_admin_proforma()
    {
        if (isset($_POST["crud"]) && $_POST["crud"] == "add") {
            $this->wrpro_agregar_proforma();
        } else if (isset($_GET["crud"]) && $_GET["crud"] == "load") {
            $this->wrpro_load_proforma();
        } else if (isset($_POST["crud"]) && $_POST["crud"] == "update") {
            $this->wrpro_actualizar_proforma();
        } else if (isset($_POST["crud"]) && $_POST["crud"] == "remove") {
            $this->wrpro_eliminar_proforma();
        } else {
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_listproforma");
        }
    }

    //load proforma para editar
    private function wrpro_load_proforma()
    {
        //llevar el id de la proforma para cargarlo
        if (isset($_GET["id_proforma"])) {
            $id_proforma = $_GET["id_proforma"];
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_listproforma&id=$id_proforma");
        }
    }
    //Cargar maximo id de proformas
    function wrpro_retorn_maximo_id_proforma()
    {
        $proximoId_proforma = $this->wrpro_maximo_id("wrpro_proforma", "id") + 1;
        return $proximoId_proforma;
    }
    //Editar proforma
    private function wrpro_actualizar_proforma()
    {
        // echo  $_POST['txtarea_tercond'];
        $codigo_cliente = sanitize_text_field($_POST['id_cliente']);
        if (empty($_POST['id_cliente'])) {
            $codigo_cliente = $this->wrpro_Save_cliente();
        } else {
            $this->wrpro_actualizar_cliente($codigo_cliente);
        }
        $this->wrpro_query_bd('START TRANSACTION'); //COMIEZA TRANSACCION 
        if (isset($_POST['id_proforma']) && ($_POST['total_all']) > 0) {
            $id_proforma = $_POST['id_proforma'];
            $fecha_inicio = sanitize_text_field($_POST['fecha_ini']);
            $fecha_fin = sanitize_text_field($_POST['fecha_fin']);
            $id_cliente =  $codigo_cliente; //sanitize_text_field($_POST['id_cliente']);

            $descuento = sanitize_text_field($_POST['wr_descuento']);
            $subtotal_descuento = sanitize_text_field($_POST['wr_subt_desc']);

            $iva_proforma = sanitize_text_field($_POST['iva']);
            $subtotal_proforma = sanitize_text_field($_POST['subtotalall']);
            $total_proforma = sanitize_text_field($_POST['total_all']);
            $texto_terminos_condiciones = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $_POST['txtarea_tercond']);

            //detalle proforma
            $cantidad_producto = ($_POST['cantidad']);
            $prec_unit = ($_POST['precio_venta']);
            //detalle producto
            $nombre_producto = ($_POST['articulo']);
            $descripcion_producto = ($_POST['descrip_prod']);

            ($this->wrpro_modificar_bd(
                'wrpro_proforma',
                array('fecha' => $fecha_inicio, 'fecha_fin' =>  $fecha_fin, 'id_cli' => $id_cliente, 'subtotal' => $subtotal_proforma, 'descuento' => $descuento, 'iva' => $iva_proforma, 'subtotalall' => $subtotal_descuento, 'total' =>  $total_proforma, 'terminos_condiciones' => $texto_terminos_condiciones),
                array("id" => $id_proforma)
            ));
            //eliminar detalle de proforma
            $this->wrpro_eliminar_bd("wrpro_det_proforma", array("id_prof" => $id_proforma));
            //Buscar productos que no se utilizan
            $lista_producto = $this->wrpro_listar_bd("wrpro_producto");
            foreach ($lista_producto  as  $key => $row) {
                $this->wrpro_eliminar_bd("wrpro_producto", array("id" => $row['id']));
            }
            $i = 0;
            while ($i < count($cantidad_producto)) {
                /**Se debe registrar productos */
                $datos_producto = ['id' => null, 'prod' => trim($nombre_producto[$i]), 'descrip' => trim($descripcion_producto[$i]), 'precio' => $prec_unit[$i]];
                $this->wrpro_agregar_datos_bd("wrpro_producto",  $datos_producto);
                $cod_producto = $this->wrpro_maximo_id("wrpro_producto", "id");
                $subtotall = ($cantidad_producto[$i]) * ($prec_unit[$i]);
                $datos_detalle = ['id_prof' => $id_proforma, 'cant_item' => $cantidad_producto[$i], 'cod_prod' => $cod_producto, 'prec_unit' => $prec_unit[$i], 'subtotal' => $subtotall];
                $this->wrpro_agregar_datos_bd("wrpro_det_proforma", $datos_detalle);
                $i = $i + 1;
            }
            $this->wrpro_query_bd('COMMIT');
            $this->wrpro_envia_mensaje(__("Proforma se actualizo correctamente"), "success");
            $this->wrpro_admin_redireccionamiento("//admin.php?page=wrpro_menu");
        } else {
            $this->wrpro_query_bd('ROLLBACK');
            $this->wrpro_envia_mensaje(__("Error en los datos, no se pudo actualizar proforma"), "danger");
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu");
        }
    }

    function wrpro_Save_cliente()
    {
        if (isset($_POST['nombre_cliente'])) {
            $nombre_cliente = sanitize_text_field($_POST['nombre_cliente']);
            $email_cliente = sanitize_email($_POST['email_cliente']);
            $ruc_cliente = sanitize_text_field($_POST['dni_ruc_cliente']);
            $telf_cliente = sanitize_text_field($_POST['telefono_cliente']);
            $observacion_cliente = sanitize_text_field($_POST['cliente_direccion']);
            $datos = [
                'id' => null,
                'nom' => $nombre_cliente,
                'email' => $email_cliente,
                'dni_ruc' =>  $ruc_cliente,
                'telf' => $telf_cliente,
                'observ' => $observacion_cliente
            ];
            $this->wrpro_agregar_datos_bd("wrpro_cliente", $datos);
            $id_cliente = $this->wrpro_maximo_id("wrpro_cliente", "id");
            return $id_cliente;
        }
    }
    //Actualizar cliente
    private function wrpro_actualizar_cliente($id_cliente)
    {
        $codigo_cliente = null;
        if (isset($_POST['nombre_cliente'])) {
            $nombre_cliente = sanitize_text_field($_POST['nombre_cliente']);
            $email_cliente = sanitize_email($_POST['email_cliente']);
            $ruc_cliente = sanitize_text_field($_POST['dni_ruc_cliente']);
            $telf_cliente = sanitize_text_field($_POST['telefono_cliente']);
            $observacion_cliente = sanitize_text_field($_POST['cliente_direccion']);
            if ($this->wrpro_modificar_bd(
                'wrpro_cliente',
                array('nom' => $nombre_cliente, 'email' => $email_cliente, 'dni_ruc' => $ruc_cliente, 'telf' => $telf_cliente, 'observ' => $observacion_cliente),
                array("id" => $id_cliente)
            )) {
                $codigo_cliente = $id_cliente;
            } else {
                echo "error no se actualiza el cliente";
            }
        }
        return $codigo_cliente;
    }

    //cargar terminos y condicioens 
    function wrpro_cargar_terminos_condiciones()
    {
        return   $descripcion_terminos_condiciones = preg_replace('/\<br(\s*)?\/?\>/i', "\n", "1. Al cliente se le cobrará después de aceptada esta cotización.
2. Para empezar el trabajo se necesita la cancelación del 50% y el saldo restante al entregar el trabajo.
3. Una vez emitida la factura dispone de 3 días laborables para emitir la retención.
4. Al incumplir las condiciones se pierde la garantía de los trabajos.");
    }

    //Cargar reportes 

    function wrpro_filtrar_date($date_inicio, $date_final)
    {
        $sql = "Where fecha between $date_inicio AND $date_final";
        $lista_proformas = $this->wrpro_listar_bd_id('wrpro_proforma', $sql);
        return $lista_proformas;
    }
}