<?php
require('../assets/fpdf/fpdf.php');
require_once'../database/config.php';



class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('../assets/img/logo.png', 10, 10, 40);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 8, 'FAKULTAS SAINS DAN TEKNOLOGI', 0, 2, 'C');

        $this->Cell(30, 4, 'PROGRAM STUDI INFORMATIKA', 0, 2, 'C');
        
        // SEFONT UNTUK ALAMAT
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(30, 8, 'Alamat : Jalan Raya Pagojengan KM 3, Kecamatan Paguyangan,', 0, 2, 'C');
        $this->Cell(30, 1, 'Kabupaten Brebes, Provinsi Jawa Tengah, Indonesia', 0, 2, 'C');
        $this->SetLineWidth(1);
        $this->Line(10,35,200,35);
        
        

        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 15);
$pdf->cell(80);
$pdf->Cell(30,7,'Data Mata Mahasiswa' ,0,1 ,'C');
$pdf->Ln(10);

$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(8,10,'NO' ,1,0,'C');
$pdf->Cell(28,10,'NIM' ,1,0,'C');
$pdf->Cell(55,10,'Nama Lengkap' ,1,0,'C');
$pdf->Cell(30,10,'Kontak' ,1,0,'C');
$pdf->Cell(45,10,'Email' ,1,0,'C');
$pdf->Cell(25,10,'Kelamin' ,1,1,'C');


$query_matkul = mysqli_query($conn, "SELECT * FROM mahasiswa") or die(mysqli_error($conn));

$no= 1;

while ( $m = mysqli_fetch_array($query_matkul) ) {
    $pdf->SetFont('Times', '', 11);
    $pdf->Cell(8,10,$no++ ,1,0,'C');
    $pdf->Cell(28,10,$m['nim'] ,1,0,'C');
    $pdf->Cell(55,10,$m['nama'],1,0,'C');
    $pdf->Cell(30,10,$m['kontak'] ,1,0,'C');
    $pdf->Cell(45,10,$m['email'],1,0,'C');
    $pdf->Cell(25,10,($m['kelamin'] == 'L' ? 'Laki-laki': 'Perempuan' ),1,1,'C');
}

$pdf->Output();
?>