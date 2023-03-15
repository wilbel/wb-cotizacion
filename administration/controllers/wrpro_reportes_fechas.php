<?php
class wrpro_imprimir_reportes
{
    function wrpro_load_detalle_proforma($id_proforma) //Retorna lista de detalle de proforma
    {
        $bd_operaciones_reportes = new WRPRO_database();
        $where = "where " .  $bd_operaciones_reportes->wrpro_get_prefijo_table() . WRPRO_database::wrpor_tabla_detalle . ".id_prof='$id_proforma'";
        $listar_detalles = $bd_operaciones_reportes->wrpro_listar_bd_id(WRPRO_database::wrpor_tabla_detalle, $where);
        return  $listar_detalles;
    }

    function wrpro_admin_reportes($fecha_inicio, $fecha_fin) //Cargar proformas rango de tiempo
    {
        $bd_operaciones_reportes = new WRPRO_database();
        $where = "where " . $bd_operaciones_reportes->wrpro_get_prefijo_table() . WRPRO_database::wrpro_tabla_proforma . ".fecha between '$fecha_inicio' AND '$fecha_fin'";
        $listar_proformas = $bd_operaciones_reportes->wrpro_listar_bd_id(WRPRO_database::wrpro_tabla_proforma, $where);
        $oper_clientes = new WRPRO_Operaciones_clientes();
        ob_start();
        $pdf = new wrpro_FPDF();
        $pdf->AddPage();
        $logo = plugin_dir_url(__FILE__) . '../../static/imagenes/webrevolution.png';
        $pdf->Image($logo, 10, 10, 18, 9, 'PNG', '');
        $pdf->SetX(30);
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(170, 5, utf8_decode('Reportes'), 0, 1, 'C', 1);
        $pdf->Ln(10);
        $pdf->SetX(110);
        $pdf->SetFillColor(185, 201, 209);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(90, 8, utf8_decode("Fecha:" . date('d-M-y')), 0, 1, 'R', True);
        $pdf->SetX(110);
        $pdf->Cell(90, 8, utf8_decode("Reporte desde: " . $fecha_inicio . "  Hasta: " . $fecha_fin), 0, 1, 'R', True);

        $subtotal = 0;
        $total = 0;
        $iva_total = 0;

        foreach ($listar_proformas as  $iterator) {
            $subtotal = $subtotal + $iterator['subtotall'];
            $total = $total + $iterator['iva'];
            $iva_total =  $iva_total + $iterator['total'];
            $pdf->Ln(1);
            $id_proforma = $iterator['id'];
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFillColor(38, 59, 100);
            $pdf->Cell(20, 8, utf8_decode('PROF.'), 1, 0, 'C', True);
            $pdf->Cell(115, 8, utf8_decode('Cliente'), 1, 0, 'C', True);
            $pdf->Cell(20, 8, utf8_decode('Iva'), 1, 0, 'C', True);
            $pdf->Cell(17, 8, utf8_decode('Subtotal'), 1, 0, 'C', True);
            $pdf->Cell(18, 8, utf8_decode('Total Prof.'), 1, 0, 'C', True);
            $pdf->Ln(8);
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(20, 8, utf8_decode($iterator['id']), 1, 0, 'C');
            $nombre_cliente = null;
            $lista_cliente =  $oper_clientes->wr_pro_load_clientes($iterator['id_cli']);
            foreach ($lista_cliente as $iterator_cliente) {
                $nombre_cliente =  $iterator_cliente['nom'];
            }
            $pdf->Cell(115, 8, utf8_decode($nombre_cliente), 1, 0, 'C');
            $pdf->Cell(20, 8, '$ ' . number_format($iterator["iva"], 2, '.', ''), 1, 0, 'C');
            $pdf->Cell(17, 8, '$ ' . number_format($iterator['subtotalall'], 2, '.', ''), 1, 0, 'C');
            $pdf->Cell(18, 8, '$ ' . number_format($iterator['total'], 2, '.', ''), 1, 0, 'C');
            $pdf->Ln(10);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFillColor(179, 217, 255);
            $pdf->Cell(20, 8, utf8_decode('Cantidad'), 1, 0, 'C', True);
            $pdf->Cell(95, 8, utf8_decode('Producto'), 1, 0, 'C', True);
            $pdf->Cell(55, 8, utf8_decode('Precio'), 1, 0, 'C', True);
            $pdf->Cell(20, 8, utf8_decode('Subtotal'), 1, 0, 'C', True);
            $pdf->Ln(8);
            $listar_detalle =  $this->wrpro_load_detalle_proforma($id_proforma);
            foreach ($listar_detalle as $det_proforma) {
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(20, 8, utf8_decode($det_proforma['cant_item']), 1, 0, 'C');
                $pdf->Cell(95, 8, utf8_decode($det_proforma['cod_prod']), 1, 0, 'C');
                $pdf->Cell(55, 8, utf8_decode($det_proforma['prec_unit']), 1, 0, 'C');
                $pdf->Cell(20, 8, utf8_decode($det_proforma['subtotal']), 1, 0, 'C');
                $pdf->Ln(8);
            }
        }

        $pdf->SetX(164);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(18, 5, "Subtotal", 0, 0, "C");
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(18, 5, '$ ' . number_format($subtotal, 2), 1, 1, "R");
        $pdf->SetX(164);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(18, 5, utf8_decode('IVA 12%'), 0, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(18, 5, '$ ' . number_format($iva_total, 2, '.', ''), 1, 1, 'R');
        $pdf->SetX(164);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(18, 5, utf8_decode('TOTAL'), 0, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(18, 5, '$ ' . number_format($total, 2, '.', ''), 1, 1, 'R');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(144, 54, 45);
        $pdf->Cell(190, 8,  utf8_decode('Para mayor información'), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(190, 5,  utf8_decode('(De Lunes a Viernes de 07:00 a 17:00 - Sabado de 07:00 a 12:00) o al teléfono celular: 0992312330 (Con atención las 24 hrs del día).'), 0, 1, 'C');
        $pdf->Cell(190, 5, 'Atentamente Web Revolution.', 0, 1, 'C');
        $pdf->output("proforma-000.pdf", "D");
        ob_end_flush();
    }
}
