<?php
defined('ABSPATH') or die('');

require_once plugin_dir_path(__FILE__) . '../../library/wrpro_reporte.php';

class wrpro_imprimir_proformas
{
    public function wrpro_imprimir_proforma($id_proforma)
    {

       


        $pdf = new WRPRO_Reporte();

        var_dump($id_proforma);
        exit;


        $pdf->AliasNbPages();






        $operaciones_bd = new WBCT_database();



        $proforma =  $operaciones_bd->wbct_listar_bd_id('wbct_cotizacion', 'where id =' . $id_proforma);







        $fecha = 0;
        $fechafin = 0;
        $id_cli = 0;
        $subtotal = 0;
        $iva = 0;
        $total = 0;
        $nomcli = 0;
        $email = 0;
        $dniruc = 0;
        $telf = 0;
        $observ = 0;
        $terminos_condiciones = null;
        $valor_iva = esc_attr(get_option('_wb_data_iva')['valor_iva']);
        foreach ($proforma  as  $key => $pro) {
            $fecha = $pro->fecha;
            $fechafin = $pro->fecha_fin;
            $id_cli = $pro->id_cli;
            $subtotalinicio = $pro->subtotal;
            $descuento = $pro->descuento;
            $subtotal = $pro->subtotalall;
            $iva = $pro->iva;
            $total = $pro->total;
            $terminos_condiciones = $pro->terminos_condiciones;
        }
        $cliente =  $operaciones_bd->wbct_listar_bd_id('wbct_cliente', 'where id =' . $id_cli);
        foreach ($cliente  as  $key => $cli) {
            $idcli = $cli->id;
            $nomcli = $cli->nombre;
            $email = $cli->email;
            $dniruc = $cli->dni_ruc;
            $telf = $cli->telefono;
            $observ = $cli->direccion;
        }
        $det_prof = $operaciones_bd->wbct_load_detalles_factura('wbct_producto', 'wbct_detalle_cotizacion', $id_proforma);



        ob_start();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $imagen = plugin_dir_url(__FILE__) . '../../static/imagenes/icon_wr.png';
        $pdf->SetFillColor(167, 65, 43);

        $pdf->Image($imagen, 40, 12, 44, 22, 'PNG', '');
        $pdf->SetXY(109, 17);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(185, 201, 209);
        //  $pdf->SetTextColor(0, 0, 0);
        $pdf->SetTextColor(38, 59, 100);
        $pdf->Cell(70, 7, utf8_decode('NÚMERO DE PROFORMA :'), 0, 0, 'C', FALSE);
        $pdf->SetXY(175, 17);
        $pdf->Cell(25, 7, utf8_decode($id_proforma), 0, 0, 'C', FALSE);
        $pdf->SetY(10);
        // $pdf->SetY(20);
        $pdf->SetX(117);
        $pdf->SetFillColor(185, 201, 209);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(14, 6, utf8_decode('FECHA:'), 0, 0, 'C', true);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(23, 6, utf8_decode($fecha), 0, 0, 'C', true);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(24, 6, 'VALIDO HASTA:', 0, 0, 'R', true);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(22, 6, utf8_decode($fechafin), 0, 0, 'C', true);
        $pdf->Ln(5);
        $pdf->SetTextColor(0, 0, 0);
        //$pdf->Sety(35);
        $pdf->SetFillColor(185, 201, 209);
        // $pdf->SetXY(20,10);
        // para arriba ,  posicion de arriba hacia abajo, hancho, alto
        $pdf->Rect(117, 24, 83, 38, 'F');
        $pdf->SetXY(118, 25);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(70, 5, utf8_decode('DIRECCIÓN:'), 0, 0, 'L', 0);
        $pdf->SetXY(129, 25);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(78, 5, '13ava Norte / 10 de Agosto y Napoleon Mera 206', 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetXY(118, 29);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(70, 6, 'GERENTE:', 0, 0, 'L', 0);
        $pdf->SetXY(118, 29);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(69, 6, '[Maximo Jordan Porras]', 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetXY(118, 33);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(70, 7, 'R.U.C:', 0, 0, 'L', 0);
        $pdf->SetXY(118, 33);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(61, 7, '[0703936401001]', 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetXY(118, 37);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(70, 8, utf8_decode('TELF. OFICINA:'), 0, 0, 'L', 0);
        $pdf->SetXY(118, 37);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(80, 8, '[02962745] - [0980993306]', 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetXY(118, 41);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(70, 9, 'CELULAR GERENCIA:', 0, 0, 'L', 0);
        $pdf->SetXY(118, 41);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(80, 9, '[0992312330]', 0, 0, 'C');
        $pdf->Ln(7);
        $pdf->SetXY(118, 45);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(70, 10, 'EMAIL:', 0, 0, 'L', 0);
        $pdf->SetXY(118, 45);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(86, 10, 'machala@webrevolutionagency.com', 0, 0, 'C');

        $pdf->Ln(7);
        $pdf->SetXY(118, 53);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(80, 4, utf8_decode('Horario de atención: Lun-Vier 7:00am - 17:00pm | Sab 7:00am - 12:00m | Via telefónica las 24h'), 0, 1);

        $pdf->SetY(37);

        $pdf->SetX(10);
        $pdf->SetFillColor(185, 201, 209);
        $pdf->SetTextColor(38, 59, 100);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(100, 5, utf8_decode(' DATOS DEL CLIENTE'), 1, 0, 'L', true);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(185, 201, 209);
        $pdf->SetX(10);
        $pdf->Cell(15, 5, utf8_decode('NOMBRE:'), 1, 0, 'C', true);
        $pdf->Cell(85, 5, utf8_decode($nomcli), 1, 0, 'D', true);
        $pdf->Ln(5);
        $pdf->SetX(10);
        $pdf->Cell(15, 5, 'TELF:', 1, 0, 'D', true);
        $pdf->Cell(85, 5, utf8_decode($telf), 1, 0, 'D', true);
        $pdf->Ln(5);
        $pdf->SetX(10);
        $pdf->Cell(15, 5, 'R.U.C:', 1, 0, 'D', true);
        $pdf->Cell(85, 5, utf8_decode($dniruc), 1, 0, 'D', true);
        $pdf->Ln(5);
        $pdf->SetX(10);
        $pdf->Cell(15, 5,  utf8_decode('DIREC:'), 1, 0, 'D', true);
        $pdf->MultiCell(85, 5, utf8_decode($observ), 1, 1, 'L');

        $pdf->SetY(33);

        $pdf->Ln(34);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(40, 5, utf8_decode('Cliente.'), 0, 1, 'L');
        $pdf->MultiCell(190, 4, utf8_decode('Reciba un cordial saludos de parte de quienes conformamos la agencia de publicidad Web Revolution Machala, le remitimos la proforma solicitada por usted en nuestro departamento técnico de Ecuador-El Oro-Machala.'), 0, 1, '');
        $pdf->SetY(82);
        //$pdf->Ln(35);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetFillColor(38, 59, 100);
        $pdf->Rect(10, 82, 190, 8, 'F');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(20, 8, utf8_decode('Cantidad'), 1, 0, 'C');
        $pdf->Cell(50, 8, utf8_decode('Producto'), 1, 0, 'C');
        $pdf->Cell(85, 8, utf8_decode('Descripción'), 1, 0, 'C');
        $pdf->Cell(17, 8, utf8_decode('Precio'), 1, 0, 'C');
        $pdf->Cell(18, 8, utf8_decode('Subtotal'), 1, 0, 'C');
        $pdf->Ln(8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 7);

        $pdf->SetFillColor(255, 255, 255); //COLOR DE LAS TABLAS
        foreach ($det_prof as $key => $det) {
            $acum_1 =  $this->wrpro_cont_lineas($det->producto); //contar la cantidad de lineas
            $acum =  $this->wrpro_cont_lineas($det->descripcion); //contar la cantidad de lineas
            $acum =  ($acum_1 > $acum) ? $acum = $acum_1 : $acum;
            $pdf->Cell(20, $acum * 5, utf8_decode($det->cant_item), 1, 0, 'C');
            $y = $pdf->GetY();
            $pdf->SetXY(31, $y + 1);
            $pdf->MultiCell(49, 5, utf8_decode($det->producto), 0, 1, 'C');
            $pdf->SetXY(80, $y);
            $pdf->MultiCell(85, 5, utf8_decode($det->descripcion), 1, 1, 'C');
            $pdf->SetXY(165, $y);
            $cantidad_decimales = strpos(strrev($det->prec_unit), ".");
            if ($cantidad_decimales < 3) {
                $precio_uni_formateado = number_format($det->prec_unit, 2, '.', '');
            } else {
                $precio_uni_formateado = number_format($det->prec_unit, 6, '.', '');
            }
            $pdf->Cell(17, $acum * 5, '$ ' . (utf8_decode($precio_uni_formateado)), 1, 0, 'R');
            $pdf->Cell(18, $acum * 5, '$ ' . number_format(utf8_decode($det->subtotal), 2, '.', ''), 1, 0, 'R');
            $pdf->Ln($acum * 5);
            $pdf->Cell(190, 0, '', 1, 1, 'C');
        }

        $pdf->SetX(164);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(18, 5, "Subtotal", 0, 0, "C");
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(18, 5, '$ ' . number_format($subtotalinicio, 2), 1, 1, "R");

        $pdf->SetX(164);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(18, 5, "Desc. $", 0, 0, "C");
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(18, 5, '$ ' . number_format($descuento, 2), 1, 1, "R");

        $pdf->SetX(164);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(18, 5, "Subt. Desc", 0, 0, "C");
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(18, 5, '$ ' . number_format($subtotal, 2), 1, 1, "R");
        $pdf->SetX(164);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(18, 5, utf8_decode('IVA ' . ($valor_iva * 100) . "%"), 0, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(18, 5, '$ ' . number_format($iva, 2, '.', ''), 1, 1, 'R');
        $pdf->SetX(164);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(18, 5, utf8_decode('TOTAL'), 0, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(18, 5, '$ ' . number_format($total, 2, '.', ''), 1, 1, 'R');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(140, 5, utf8_decode('Contribuyente Régimen RIMPE'), 0, 1, 'L');

        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(167, 65, 43);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(140, 5, utf8_decode('TÉRMINOS Y CONDICIONES'), 1, 1, 'D');

        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(140, 5, utf8_decode($terminos_condiciones), 1, 1);

        $pdf->Ln(4);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->MultiCell(140, 5, utf8_decode('DEPARTAMENTO TÉCNICO DE ECUADOR'), 1, 1, 'D');
        $pdf->SetX(10);
        $pdf->SetTextColor(36, 85, 175);
        $pdf->Cell(140, 5, utf8_decode('www.webrevolutionagency.com/'), 1, 1, 'D');
        $pdf->Cell(140, 5, utf8_decode('https://agenciadepublicidadecuador.com/'), 1, 1, 'D');
        $pdf->Cell(140, 5, utf8_decode('https://ecuadorcupon.com/'), 1, 1, 'D');
        $pdf->Cell(140, 5, utf8_decode('https://imprentawebrevolution.com/'), 1, 0, 'D');
        $pdf->Ln(7);
        $pdf->SetTextColor(0, 0, 0);
        // $pdf->Output();
        $pdf->output("proforma-000" . $id_proforma . ".pdf", "D");
        ob_end_flush();
    }

    function wrpro_admin_proforma($id_proforma)
    {
        //Imprimir proforma
        if (isset($_POST["crud"]) && $_POST["crud"] == "add") {


            $this->wrpro_imprimir_proforma($id_proforma);
        }
    }

    function wrpro_cont_lineas($text)
    {
        $exp = explode("\n", $text);
        $lineas = count($exp);
        return $lineas;
    }
}
