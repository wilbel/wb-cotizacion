<?php
class WRPRO_Operaciones_configuraciones extends WRPRO_database
{
    function __construct()
    {
        parent::__construct();
    }
    //Agregar numero con el que empieza la proforma
    private function wrpro_agregar_numeracion()
    {
        if (isset($_POST['numero_codigo']) && !empty($_POST['numero_codigo'])) {
            $numero_proforma = sanitize_text_field($_POST['numero_codigo']);
            if ($this->wrpro_agregar_numeracion_proforma("wrpro_proforma",  $numero_proforma)) {
                $this->wrpro_envia_mensaje(__("Numeración ingresada correctamente"), "success");
            } else {
                $this->wrpro_envia_mensaje(__("A ocurrido un error"), "danger");
            }
        } else {
            $this->wrpro_envia_mensaje(__("A ocurrido un error"), "danger");
        }
        $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_configuracion");
    }

    function wrpro_configuracion_proforma()
    {
        if (isset($_POST["numeracion"]) && $_POST["numeracion"] == "numeracion_proforma") {
            $this->wrpro_agregar_numeracion(); //opcion numeracion de la proforma
        } else if (isset($_POST["wr_configuracion"]) && $_POST["wr_configuracion"] == "configuracion_valores") {
            $this->wbct_save_iva();
        } else {
            $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_configuracion");
        }
    }

    function wbct_save_iva()
    {
        $valorIva = sanitize_text_field($_POST['valorIva']);
        if (isset($_POST['valorIva'])) {
            $valores_data = array('valor_iva' => $valorIva);
            update_option('_wb_data_iva', $valores_data);
            $this->wrpro_envia_mensaje(__("Datos registrados"), "success");
        } else {
            $this->wrpro_envia_mensaje(__("Error al registrar datos "), "danger");
        }
        $this->wrpro_admin_redireccionamiento("/admin.php?page=wrpro_menu_configuracion");
    }
}
