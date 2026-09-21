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
        
        // Move to the right
        $this->Cell(80);
        $this->SetFont('Arial', 'B', 16);
        // Title
        $this->Cell(30, 8, 'FAKULTAS SAINS DAN TEKNOLOGI', 0, 2, 'C');

        $this->Cell(30, 4, 'PROGRAM STUDI INFORMATIKA', 0, 2, 'C');
        
        // SEFONT UNTUK ALAMAT
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(30, 8, 'Alamat : Jalan Raya Pagojengan KM 3, Kecamatan Paguyangan,', 0, 2, 'C');
        $this->Cell(30, 1, 'Kabupaten Brebes, Provinsi Jawa Tengah, Indonesia', 0, 2, 'C');
        $this->SetLineWidth(1);
        $this->Line(10,40,200,40);
        
        

        $this->Ln(15);
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
$nim = @$_GET['nim'];
$query_ambil_data = mysqli_query($conn,"SELECT * FROM mahasiswa WHERE nim = '$nim'") or die(mysqli_error($conn));
$result = mysqli_fetch_array($query_ambil_data);

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 15);
$pdf->cell(80);
$pdf->Cell(30,7,'SURAT AKTIF KULIAH' ,0,1 ,'C');
$pdf->Ln(12);

$pdf->cell(45);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(30,7,'Dengan surat ini, Universitas Peradaban Bumiayu Menyatakan bahwa:' ,0,1 ,'C');
$pdf->Ln(12);


$pdf->SetFont('Times', '', 12);
$pdf->Cell(30,7,'NIM                 : '.$result['nim'] ,0,1 ,'L');
$pdf->Cell(30,7,'Nama               : '.$result['nama'] ,0,1 ,'L');
$pdf->Cell(30,7,'Kontak             : '.$result['kontak'] ,0,1 ,'L');
$pdf->Cell(30,7,'Email               : '.$result['email'] ,0,1 ,'L');
$pdf->Cell(30,7,'Jenis Kelamin  : ' .($result['kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan') ,0,1 ,'L');
$pdf->Ln(12);
$pdf->Cell(30,7,'Adalah Mahasisiswa Universitas Peradaban Sampai sekarang masih aktif kuliah.' ,0,1 ,'L');
$pdf->Ln(12);
$pdf->Cell(30,7,'Demikian Surat ini dibuat dengan sebenar benarnya untuk dapat digunakan seperlunya.' ,0,1 ,'L');
$pdf->Ln(20);
$pdf->cell(145);
$pdf->Cell(30,7,'Rektor Universitas peradaban' ,0,1 ,'R');
$pdf->Ln(20);

$pdf->cell(130);
$pdf->Cell(30,7,'Sutarmin' ,0,1 ,'R');
$pdf->Ln(12);


$pdf->Output();
?>