<?php
defined('ABSPATH') or die('');
if (!class_exists('FPDF')) {
    require plugin_dir_path(__FILE__) . 'fpdf/fpdf.php';
}
class WRPRO_Reporte extends wrpro_FPDF
{
    function __construct()
    {
        parent::__construct();
    }

    function Footer()
    {
        /*$imagen_wr = plugin_dir_url(__FILE__) . '../static/imagenes/icon_wr.png';
        $imagen_ec_cupon = plugin_dir_url(__FILE__) . '../static/imagenes/icon_ecupon.png';
        $this->SetY(-20);
        $this->SetFillColor(167, 65, 43);
        $this->MultiCell(190, 0.5, '', 0, 0, 'L');
        $this->Ln(2);

        $this->SetFont('Arial', 'I', 7);
        $this->Image($imagen_wr, 10, 280, 25, 12, 'PNG', '');
        $this->Image($imagen_ec_cupon, 175, 280, 25, 12, 'PNG', '');
        $this->SetX(40);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 3, 'GERENTE:', 0, 0, 'L', 0);
        $this->Ln(3);
        $this->SetX(40);
        $this->SetFont('Arial', '', 7);
        $this->Cell(10, 3, '[Maximo Jordan Porras]', 0, 0, 'L');
        $this->Ln(3);
        $this->SetX(40);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 3, 'R.U.C:', 0, 0, 'L', 0);
        $this->Ln(3);
        $this->SetX(40);
        $this->SetFont('Arial', '', 7);
        $this->Cell(10, 3, '[0703936401001]', 0, 0, 'L');

        $this->SetY(-20);
        $this->Ln(2);
        $this->SetX(80);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 3, 'CELULAR GERENCIA:', 0, 0, 'L', 0);
        $this->Ln(3);
        $this->SetX(80);
        $this->SetFont('Arial', '', 7);
        $this->Cell(10, 3, '[0992312330]', 0, 0, 'L');

        $this->Ln(3);
        $this->SetX(80);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 3, utf8_decode('TELF. OFICINA:'), 0, 0, 'L', 0);
        $this->Ln(3);
        $this->SetX(80);
        $this->SetFont('Arial', '', 7);
        $this->Cell(10, 3, '[02962745] - [0980993306]', 0, 0, 'L');

        $this->SetY(-20);
        $this->Ln(2);
        $this->SetX(120);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 3, utf8_decode('DIRECCIÓN:'), 0, 0, 'L', 0);
        $this->Ln(3);
        $this->SetX(120);
        $this->SetFont('Arial', '', 7);
        $this->Cell(10, 3, utf8_decode('13ava Norte / 10 de Agosto y Napoleon Mera 206'), 0, 0, 'L');

        $this->Ln(3);
        $this->SetX(120);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 3, 'EMAIL:', 0, 0, 'L', 0);
        $this->Ln(3);
        $this->SetX(120);
        $this->SetFont('Arial', '', 7);
        $this->Cell(10, 3, 'machala@webrevolutionagency.com', 0, 0, 'L');*/
    }
}
