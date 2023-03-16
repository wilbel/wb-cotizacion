<?php

class WBCT_OperacionesClientes extends WBCT_database
{
    function __construct()
    {
        parent::__construct();
    }
    //Registrar clientes
    private function wrpoc_agregar_cliente()
    {
        if (isset($_POST['nombre_cliente']) && !empty($_POST['email_cliente'])) {
            $nombre_cliente = sanitize_text_field($_POST['nombre_cliente']);
            $email_cliente = sanitize_email($_POST['email_cliente']);
            $ruc_cliente = sanitize_text_field($_POST['ruc_dni_cliente']);
            $telf_cliente = sanitize_text_field($_POST['telefono_cliente']);
            $observacion_cliente = sanitize_text_field($_POST['observacion_cliente']);
            $datos = [
                'id' => null, 'nom' => $nombre_cliente,
                'email' => $email_cliente,
                'dni_ruc' => $ruc_cliente,
                'telefono' => $telf_cliente,
                'observacion' => $observacion_cliente
            ];
            $bandera =  $this->wrpro_agregar_datos_bd("wrpro_cliente", $datos);
            if ($bandera) {
                $this->wrpro_envia_mensaje(__("Cliente guardado correctamente"), "success");
            } else {
                $this->wrpro_envia_mensaje(__("Error al registrar cliente"), "danger");
            }
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_clientes");
        } else {
            $this->wrpro_envia_mensaje(__("Error al registrar cliente"), "danger");
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_clientes");
        }
    }

    function wrpoc_admin_cliente()
    {
        if (isset($_POST["crud"]) && $_POST["crud"] == "add") {
            $this->wrpoc_agregar_cliente();
        } else if (isset($_POST["crud"]) && $_POST["crud"] == "update") {
            $this->wrpoc_actualizar_cliente();
        } else if (isset($_POST["crud"]) && $_POST["crud"] == "remove") {
            $this->wrpoc_eliminar_cliente();
        } else {
            $this->wrpro_admin_redireccionamiento("/admin.php?page=sp_menu_clientes");
        }
    }

    //Editar los datos
    private function wrpoc_actualizar_cliente()
    {
        if (isset($_POST['nombre_cliente'])) {
            $id_cliente = sanitize_text_field($_POST['id_cliente']);
            $nombre_cliente = sanitize_text_field($_POST['nombre_cliente']);
            $email_cliente = sanitize_email($_POST['email_cliente']);
            $ruc_cliente = sanitize_text_field($_POST['ruc_dni_cliente']);
            $telf_cliente = sanitize_text_field($_POST['telefono_cliente']);
            $observacion_cliente = sanitize_text_field($_POST['observacion_cliente']);
            if ($this->wrpro_modificar_bd(
                'wrpro_cliente',
                array('nom' => $nombre_cliente, 'email' => $email_cliente, 'dni_ruc' => $ruc_cliente, 'telf' => $telf_cliente, 'observ' => $observacion_cliente),
                array("id" => $id_cliente)
            )) {
                $this->wrpro_envia_mensaje(__("Cliente actualizado correctamente"), "success");
            } else {
                $this->wrpro_envia_mensaje(__("Error al actualizar cliente"), "danger");
            }
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_clientes");
        } else {
            $this->wrpro_envia_mensaje(__("Error al actualizar cliente,revisar datos"), "danger");
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_clientes");
        }
    }
    //Eliminar cliente
    private function wrpoc_eliminar_cliente()
    {
        if (isset($_POST['eliminar_cliente']) && !empty($_POST['eliminar_cliente'])) {
            $idclient = sanitize_text_field($_POST['eliminar_cliente']);
            if ($this->wrpro_eliminar_bd("wrpro_cliente", array("id" => $idclient))) {
                $this->wrpro_envia_mensaje(__("Cliente eliminado correctamente"), "success");
            } else {
                $this->wrpro_envia_mensaje(__("Error al eliminar cliente"), "danger");
            }
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_clientes");
        } else {
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_clientes");
        }
    }

    //cargar todos los clientes
    function wr_load_cliente()
    {
        $lista_cliente = $this->wrpro_listar_bd("wrpro_cliente");
        return $lista_cliente;
    }

    //Cargar un id cliente
    function wr_pro_load_clientes($id_cliente)
    {
        $aux = 'where id=' . $id_cliente;
        $lista_cliente =  $this->wrpro_listar_bd_id("wrpro_cliente", $aux);
        return $lista_cliente;
    }
}
