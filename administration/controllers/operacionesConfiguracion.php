<?php
class WBCT_OperacionesConfiguraciones extends WBCT_database
{
    function __construct()
    {
        parent::__construct();
    }
    private function agregarNumeracion()
    {
        if (isset($_POST['numero_codigo']) && !empty($_POST['numero_codigo'])) {
            $numero_proforma = sanitize_text_field($_POST['numero_codigo']);
            if ($this->wbct_agregar_numeracion_cotizacion("wbct_cotizacion",  $numero_proforma)) {
                $this->wbctEnviaMensaje(__("Numeración ingresada correctamente"), "success");
            } else {
                $this->wbctEnviaMensaje(__("A ocurrido un error"), "danger");
            }
        } else {
            $this->wbctEnviaMensaje(__("A ocurrido un error"), "danger");
        }
        $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_configuracion");
    }

    function wbct_configuracion_cotizacion()
    {
        if (isset($_POST["numeracion"]) && $_POST["numeracion"] == "numeracion_proforma") {
            $this->agregarNumeracion();
        } else if (isset($_POST["wb_configuracion"]) && $_POST["wb_configuracion"] == "configuracion_valores") {
            $this->wbct_save_iva();
        } else if (isset($_POST["wb_logo"]) && $_POST["wb_logo"] == "configuracion_logo") {

            $this->wbct_save_image();
        } else if (isset($_POST["wb_condiciones"]) && $_POST["wb_condiciones"] == "configuracion_condicion") {

            $texto_terminos_condiciones = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $_POST['condiciones']);
            if (isset($_POST['condiciones'])) {
                $valores_data = array('datos_condiciones' => $texto_terminos_condiciones);
                update_option('_wb_data_condiciones', $valores_data);

                $this->wbctEnviaMensaje(__("Datos registrados"), "success");
            } else {
                $this->wbctEnviaMensaje(__("Error al registrar datos "), "danger");
            }
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_configuracion");
        } else {
            $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_configuracion");
        }
    }

    function wbct_save_iva()
    {
        $valorIva = sanitize_text_field($_POST['valorIva']);
        if (isset($_POST['valorIva'])) {
            $valores_data = array('valor_iva' => $valorIva);
            update_option('_wb_data_iva', $valores_data);
            $this->wbctEnviaMensaje(__("Datos registrados"), "success");
        } else {
            $this->wbctEnviaMensaje(__("Error al registrar datos "), "danger");
        }
        $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_configuracion");
    }


    function wbct_save_image()
    {
        $imagen = sanitize_text_field($_POST['txtimage']);
        if (isset($_POST['txtimage'])) {
            $valores_data = array('wbct_logo' => $imagen);
            update_option('_wb_data_imagen', $valores_data);
            $this->wbctEnviaMensaje(__("Datos registrados"), "success");
        } else {
            $this->wbctEnviaMensaje(__("Error al registrar datos "), "danger");
        }
        $this->wbct_admin_redireccionamiento("/admin.php?page=wbct_menu_configuracion");
    }
}
