<?php
define('FPDF_FONTPATH','.');
require('../FPDF.php');

$pdf = new FPDF();
$pdf->AddFont('Calligrapher','','calligra.php');
$pdf->AddPage();
$pdf->SetFont('Calligrapher','',35);
$pdf->Cell(0,10,'Changez de police avec FPDF !');
$pdf->Output();
?>
