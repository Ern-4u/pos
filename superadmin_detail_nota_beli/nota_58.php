<?php
require('../assets/fpdf/fpdf.php');
require_once'../database/config.php';

$tanggal = date('dmy');
$kode_nota = $_GET['kode_nota'];

$data_detail_transaksi = mysqli_query($conn, "SELECT detail_nota_beli.* ,barang.nama_barang 
FROM detail_nota_beli
LEFT JOIN barang ON detail_nota_beli.kode_barang = barang.kode_barang 
WHERE detail_nota_beli.kode_nota ='$kode_nota'")or die(mysqli_error($conn));

$detail = [];

while ($dt = mysqli_fetch_array($data_detail_transaksi)) {
    $detail[] = $dt;
}

$tinggi_header = 60;
$tinggi_per_barang = 8;
$tinggi_footer = 15;

$jumlah_barang = count($detail);

$tinggi_nota = $tinggi_header 
             + ($jumlah_barang * $tinggi_per_barang) 
             + $tinggi_footer;

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->Image('../assets/img/tmi-hitamputih.jpg', 5, 5,8,6);
        
        $this->SetY(5);
        
        $this->SetX(2);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(53 ,3,'Nota Transaksi' ,0,1 ,'C');
        $this->Ln(1);
        $this->SetFont('Times', '', 8);
        $tanggal = date('d F Y');
        $this->SetX(2);
        $this->Cell(53 ,3,$tanggal ,0,1 ,'C');
        
        $this->SetLineWidth(0.5);
        $this->SetX(2);
        $this->Line(5,15,55,15);
        $this->Ln(8);
    }

    // Page footer
   
}

// Instanciation of inherited class
$pdf = new PDF('P', 'mm', array(58,$tinggi_nota));
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 8);
$pdf->SetX(2);
$pdf->Cell(57, 8, 'NOMOR NOTA : '.$kode_nota, 0, 1, 'C');

$pdf->SetFont('Times', 'B', 8);

$pdf->SetX(5);
$pdf->SetX(2);

$pdf->Cell(30, 6, 'BARANG', 0, 0, 'L');
$pdf->Cell(7, 6, 'QTY', 0, 0, 'L');
$pdf->Cell(13, 6, 'TOTAL', 0, 1, 'L');

mysqli_data_seek($data_detail_transaksi, 0);
while ($dt = mysqli_fetch_array($data_detail_transaksi)) {
    $pdf->SetFont('Times', '', 8);
    $pdf->SetX(5);
    $pdf->SetX(2);
    $pdf->Cell(30, 5, $dt['nama_barang'].' - harga : Rp'.$dt['harga_beli'], 0, 0, 'L');
    $pdf->Cell(7, 4, $dt['jumlah'], 0, 0, 'C');
    $pdf->Cell(15, 5, 'Rp'.$dt['total_harga_beli'], 0, 1, 'L');
}

        $pdf->SetY(-35);
        $pdf->SetLineWidth(0.5);
        
        // Arial italic 8
        $pdf->SetFont('Arial', 'B', 8);
        // Page number
        $pdf->SetX(3);
        $pdf->Cell(51, 5, '_______________________________', 0, 1, 'C');
        $kode_nota = $_GET['kode_nota'];
        $query_total =mysqli_query($conn, "SELECT total_pembelian FROM nota_beli WHERE kode_nota = $kode_nota") or die(mysqli_error($conn));
        $total = mysqli_fetch_array($query_total);
        $pdf->SetX(3);
        $pdf->Cell(51, 3, 'TOTAL TRANSAKSI : Rp'.$total['total_pembelian'] , 0, 1, 'C');

        $pdf->ln(1);

        $pdf->SetFont('Arial', 'I', 8);
        $pdf->SetX(3);
        $pdf->Cell(51, 3, 'Terimakasih sudah berbelanja >_<' , 0, 1, 'C');


$pdf->Output();
?>