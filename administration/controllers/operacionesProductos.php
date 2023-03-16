<?php

class WRPRO_Operaciones_producto extends WBCT_database
{
    function __construct()
    {
        parent::__construct();
    }
    //Registrar productos
    private function wrpro_agregar_producto()
    {
        if (isset($_POST['nombre_producto']) && !empty($_POST['descripcion_producto'])) {
            $nombre_producto = sanitize_text_field($_POST['nombre_producto']);
            $descripcion_producto = sanitize_text_field($_POST['descripcion_producto']);
            $precio_producto = sanitize_text_field($_POST['precio_producto']);
            $datos = [
                'id' => null,
                'prod' => $nombre_producto,
                'descrip' => $descripcion_producto,
                'precio' =>  $precio_producto,
            ];
            if ($this->wrpro_agregar_datos_bd("wrpro_producto", $datos)) {
                $this->wrpro_envia_mensaje(__("Producto guardada correctamente"), "success");
            } else {
                $this->wrpro_envia_mensaje(__("Error al registrar producto"), "danger");
            }
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_producto");
        } else {
            $this->wrpro_envia_mensaje(__("Error faltan datos"), "danger");
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_producto");
        }
    }

    function wrpro_admin_producto()
    {
        if (isset($_POST["crud"]) && $_POST["crud"] == "add") {
            $this->wrpro_agregar_producto();
        } else if (isset($_POST["crud"]) && $_POST["crud"] == "update") {
            $this->wrpro_actualizar_producto();
        } else if (isset($_POST["crud"]) && $_POST["crud"] == "remove") {
            $this->wrpro_eliminar_producto();
        } else {
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_producto");
        }
    }

    //Editar los datos
    private function wrpro_actualizar_producto()
    {
        if (isset($_POST['nombre_producto']) && !empty($_POST['descripcion_producto'])) {
            $id_producto = sanitize_text_field($_POST['id_producto']);
            $nombre_producto = sanitize_text_field($_POST['nombre_producto']);
            $descripcion_producto = sanitize_text_field($_POST['descripcion_producto']);
            $precio_producto = sanitize_text_field($_POST['precio_producto']);

            if ($this->wrpro_modificar_bd(
                'wrpro_producto',
                array('prod' => $nombre_producto, 'descrip' => $descripcion_producto, 'precio' => $precio_producto),
                array("id" => $id_producto)
            )) {
                $this->wrpro_envia_mensaje(__("Producto actualizado correctamente"), "success");
                $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_producto");
            } else {
                $this->wrpro_envia_mensaje(__("Error al actualizar producto"), "danger");
                $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_producto");
            }
        } else {
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_producto");
        }
    }

    //Eliminar cliente
    private function wrpro_eliminar_producto()
    {
        if (isset($_POST['eliminar_producto']) && !empty($_POST['eliminar_producto'])) {
            $id_producto = $_POST['eliminar_producto'];

            if ($this->wrpro_eliminar_bd("wrpro_producto", array("id" => $id_producto))) {
                $this->wrpro_envia_mensaje(__("Producto eliminado correctamente"), "success");
            } else {

                $this->wrpro_envia_mensaje(__("Error al eliminar producto"), "danger");
            }
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_producto");
        } else {
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_producto");
        }
    }
  
   
    //Cargar producto por id
    function wrpro_load_producto($id_producto)
    {
        $aux = 'where id=' . $id_producto;
        $lista_producto =  $this->wrpro_listar_bd_id("wrpro_producto", $aux);
        return $lista_producto;
    }
}
