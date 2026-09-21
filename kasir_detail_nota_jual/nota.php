<?php
require_once '../database/config.php';
require('../assets/fpdf/fpdf.php');

if (@$_SESSION['peran'] != 'S') {
  exit("Akses ditolak");
}

$kode_nota = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

if (empty($kode_nota)) {
    die("Kode nota tidak valid!");
}

// Ambil Header Data Nota Penjualan
$q_nota = mysqli_query($conn, "
    SELECT n.*, s.nama_suplier 
    FROM nota_jual n 
    LEFT JOIN suplier s ON n.kode_suplier = s.kode_suplier 
    WHERE n.kode_nota = '$kode_nota'
") or die(mysqli_error($con));

$d_nota = mysqli_fetch_assoc($q_nota);
if (!$d_nota) {
    die("Data nota tidak ditemukan!");
}

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 5, 'POS SYSTEM', 0, 1, 'C');
        
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 4, 'Struk Nota Penjualan Barang', 0, 1, 'C');
        
        $this->SetLineWidth(0.2);
        $this->Line(5, 17, 75, 17);
        $this->Ln(4);
    }

    function Footer()
    {
        $this->SetY(-12);
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(0, 8, 'Terima Kasih Atas Kunjungan Anda', 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', array(80, 100));
$pdf->SetMargins(5, 5, 5);
$pdf->AliasNbPages();
$pdf->AddPage();

// Informasi Nota Penjualan
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(20, 4, 'No. Nota', 0, 0, 'L');
$pdf->Cell(2, 4, ':', 0, 0, 'C');
$pdf->Cell(33, 4, $d_nota['kode_nota'], 0, 1, 'L');

$pdf->Cell(20, 4, 'Tanggal', 0, 0, 'L');
$pdf->Cell(2, 4, ':', 0, 0, 'C');
$pdf->Cell(33, 4, date('d-m-Y H:i', strtotime($d_nota['tgl_penjualan'])), 0, 1, 'L');

$pdf->Cell(20, 4, 'Pembeli', 0, 0, 'L');
$pdf->Cell(2, 4, ':', 0, 0, 'C');
$pdf->Cell(33, 4, $d_nota['nama_suplier'], 0, 1, 'L');

$pdf->Ln(2);
$this_line = str_repeat('-', 41);
$pdf->Cell(0, 3, $this_line, 0, 1, 'C');
$pdf->Ln(1);

$q_detail = mysqli_query($conn, "
    SELECT d.*, b.nama_barang
    FROM detail_nota_jual d 
    LEFT JOIN barang b ON d.kode_barang = b.kode_barang 
    WHERE d.kode_nota = '$kode_nota'
") or die(mysqli_error($conn));

if (mysqli_num_rows($q_detail) > 0) {
    while ($d = mysqli_fetch_array($q_detail)) {
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 4, $d['nama_barang'], 0, 1, 'L');

        $detail_item = $d['jumlah'] . ' x ' . number_format($d['harga_jual'], 0, ',', '.');
        $subtotal_item = 'Rp ' . number_format($d['total_harga_jual'], 0, ',', '.');

        $pdf->Cell(35, 4, $detail_item, 0, 0, 'L');
        $pdf->Cell(35, 4, $subtotal_item, 0, 1, 'R');
    }
} else {
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 4, 'Belum ada item barang terjual.', 0, 1, 'C');
}

$pdf->Ln(1);
$pdf->Cell(0, 3, $this_line, 0, 1, 'C');
$pdf->Ln(2);

// Total Penjualan
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 5, 'TOTAL', 0, 0, 'L');
$pdf->Cell(40, 5, 'Rp ' . number_format($d_nota['total_penjualan'], 0, ',', '.'), 0, 1, 'R');

if (!empty($d_nota['keterangan'])) {
    $pdf->SetFont('Arial', '', 7);
    $pdf->Ln(2);
    $pdf->Cell(0, 3, 'Ket: ' . $d_nota['keterangan'], 0, 1, 'L');
}

$pdf->Output('I', 'Struk_Penjualan_' . $d_nota['kode_nota'] . '.pdf');
?>