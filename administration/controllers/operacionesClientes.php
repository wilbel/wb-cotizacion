<?php

class WBCT_OperacionesClientes extends WBCT_database
{
    function __construct()
    {
        parent::__construct();
    }
    //Registrar clientes
    private function wbctAgregarCliente()
    {
        if (isset($_POST['nombre_cliente']) && !empty($_POST['email_cliente'])) {
            $nombre_cliente = sanitize_text_field($_POST['nombre_cliente']);
            $email_cliente = sanitize_email($_POST['email_cliente']);
            $ruc_cliente = sanitize_text_field($_POST['ruc_dni_cliente']);
            $telf_cliente = sanitize_text_field($_POST['telefono_cliente']);
            $direccion_cliente = sanitize_text_field($_POST['direccion_cliente']);
            $datos = [
                'id' => null,
                'nombre' => $nombre_cliente,
                'email' => $email_cliente,
                'dni_ruc' => $ruc_cliente,
                'telefono' => $telf_cliente,
                'direccion' => $direccion_cliente
            ];
            $bandera =  $this->wbct_agregar_datos_bd("wbct_cliente", $datos);
            if ($bandera) {
                $this->wbctEnviaMensaje(__("Cliente guardado correctamente"), "success");
            } else {
                $this->wbctEnviaMensaje(__("Error al registrar cliente"), "danger");
            }
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_clientes");
        } else {
            $this->wbctEnviaMensaje(__("Error al registrar cliente"), "danger");
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_clientes");
        }
    }

    function wrpoc_admin_cliente()
    {
        if (isset($_POST["crud"]) && $_POST["crud"] == "add") {
            $this->wbctAgregarCliente();
        } else if (isset($_POST["crud"]) && $_POST["crud"] == "update") {
            $this->wbctActualizarCliente();
        } else if (isset($_POST["crud"]) && $_POST["crud"] == "remove") {
            $this->wbctEliminarCliente();
        } else {
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_clientes");
        }
    }

    //Editar los datos
    private function wbctActualizarCliente()
    {
        if (isset($_POST['nombre_cliente'])) {
            $id_cliente = sanitize_text_field($_POST['id_cliente']);
            $nombre_cliente = sanitize_text_field($_POST['nombre_cliente']);
            $email_cliente = sanitize_email($_POST['email_cliente']);
            $ruc_cliente = sanitize_text_field($_POST['ruc_dni_cliente']);
            $telf_cliente = sanitize_text_field($_POST['telefono_cliente']);
            $direccion_cliente = sanitize_text_field($_POST['direccion_cliente']);
            if ($this->wbct_modificar_bd(
                'wbct_cliente',
                array('nombre' => $nombre_cliente, 'email' => $email_cliente, 'dni_ruc' => $ruc_cliente, 'telefono' => $telf_cliente, 'direccion' => $direccion_cliente),
                array("id" => $id_cliente)
            )) {
                $this->wbctEnviaMensaje(__("Cliente actualizado correctamente"), "success");
            } else {
                $this->wbctEnviaMensaje(__("Error al actualizar cliente"), "danger");
            }
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_clientes");
        } else {
            $this->wbctEnviaMensaje(__("Error al actualizar cliente,revisar datos"), "danger");
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_clientes");
        }
    }
    //Eliminar cliente
    private function wbctEliminarCliente()
    {
        if (isset($_POST['eliminar_cliente']) && !empty($_POST['eliminar_cliente'])) {
            $idclient = sanitize_text_field($_POST['eliminar_cliente']);
            if ($this->wbct_eliminar_bd("wbct_cliente", array("id" => $idclient))) {
                $this->wbctEnviaMensaje(__("Cliente eliminado correctamente"), "success");
            } else {
                $this->wbctEnviaMensaje(__("Error al eliminar cliente"), "danger");
            }
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_clientes");
        } else {
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_clientes");
        }
    }

    //cargar todos los clientes
    function wr_load_cliente()
    {
        $lista_cliente = $this->wbct_listar_bd("wbct_cliente");
        return $lista_cliente;
    }

    //Cargar un id cliente
    function wr_pro_load_clientes($id_cliente)
    {
        $aux = 'where id=' . $id_cliente;
        $lista_cliente =  $this->wbct_listar_bd_id("wbct_cliente", $aux);
        return $lista_cliente;
    }
}
