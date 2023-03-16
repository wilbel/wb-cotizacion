<?php

class WBCT_OperacionesProducto extends WBCT_database
{
    function __construct()
    {
        parent::__construct();
    }

    private function wbctAgregarProducto()
    {
        if (isset($_POST['nombre_producto']) && !empty($_POST['descripcion_producto'])) {
            $nombre_producto = sanitize_text_field($_POST['nombre_producto']);
            $descripcion_producto = sanitize_text_field($_POST['descripcion_producto']);
            $precio_producto = sanitize_text_field($_POST['precio_producto']);
            $datos = [
                'id' => null,
                'producto' => $nombre_producto,
                'descripcion' => $descripcion_producto,
                'precio' =>  $precio_producto,
            ];
            if ($this->wbct_agregar_datos_bd("wbct_producto", $datos)) {
                $this->wbctEnviaMensaje(__("Producto guardada correctamente"), "success");
            } else {
                $this->wbctEnviaMensaje(__("Error al registrar producto"), "danger");
            }
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_producto");
        } else {
            $this->wbctEnviaMensaje(__("Error faltan datos"), "danger");
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_producto");
        }
    }

    function wbct_admin_producto()
    {
        if (isset($_POST["crud"]) && $_POST["crud"] == "add") {
            $this->wbctAgregarProducto();
        } else if (isset($_POST["crud"]) && $_POST["crud"] == "update") {
            $this->wbctActualizarProducto();
        } else if (isset($_POST["crud"]) && $_POST["crud"] == "remove") {
            $this->wrpro_eliminar_producto();
        } else {
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_producto");
        }
    }

    //Editar los datos
    private function wbctActualizarProducto()
    {
        if (isset($_POST['nombre_producto']) && !empty($_POST['descripcion_producto'])) {
            $id_producto = sanitize_text_field($_POST['id_producto']);
            $nombre_producto = sanitize_text_field($_POST['nombre_producto']);
            $descripcion_producto = sanitize_text_field($_POST['descripcion_producto']);
            $precio_producto = sanitize_text_field($_POST['precio_producto']);

            if ($this->wbct_modificar_bd(
                'wbct_producto',
                array('producto' => $nombre_producto, 'descripcion' => $descripcion_producto, 'precio' => $precio_producto),
                array("id" => $id_producto)
            )) {
                $this->wbctEnviaMensaje(__("Producto actualizado correctamente"), "success");
                $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_producto");
            } else {
                $this->wbctEnviaMensaje(__("Error al actualizar producto"), "danger");
                $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_producto");
            }
        } else {
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_producto");
        }
    }

    //Eliminar cliente
    private function wrpro_eliminar_producto()
    {
        if (isset($_POST['eliminar_producto']) && !empty($_POST['eliminar_producto'])) {
            $id_producto = $_POST['eliminar_producto'];

            if ($this->wbct_eliminar_bd("wbct_producto", array("id" => $id_producto))) {
                $this->wbctEnviaMensaje(__("Producto eliminado correctamente"), "success");
            } else {

                $this->wbctEnviaMensaje(__("Error al eliminar producto"), "danger");
            }
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_producto");
        } else {
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_producto");
        }
    }

    //Cargar producto por id
    function wbct_load_producto($id_producto)
    {
        $aux = 'where id=' . $id_producto;
        $lista_producto =  $this->wbct_listar_bd_id("wbct_producto", $aux);
        return $lista_producto;
    }
}
