<?php
require_once '../database/config.php';

if (isset($_POST['btn_edit'])) {

    $kode_nota = trim(mysqli_real_escape_string($conn, $_POST['kode_nota']));
    $kode_suplier = trim(mysqli_real_escape_string($conn, $_POST['kode_suplier']));
    $total_pembelian = trim(mysqli_real_escape_string($conn, $_POST['total_pembelian']));
    $tgl_pembelian = trim(mysqli_real_escape_string($conn, $_POST['tgl_pembelian']));
    $status = trim(mysqli_real_escape_string($conn, $_POST['status']));
    $keterangan = trim(mysqli_real_escape_string($conn, $_POST['keterangan']));

            $query_simpan = mysqli_query($conn, "UPDATE nota_beli
            SET 
            kode_suplier='$kode_suplier',
            total_pembelian='$total_pembelian',
            tgl_pembelian='$tgl_pembelian',
            status='$status',
            keterangan='$keterangan'
            WHERE kode_nota='$kode_nota'
            ") or die (mysqli_error($conn)) ;


            if ($query_simpan){
            echo '<script> alert("Data Berhasil Di Edit"); 
            window.location.href="../kasir_nota_beli" </script>';
            } else {
              echo '<script> alert("Data Gagal Di Edit"); 
            window.location.href="../kasir_nota_beli" </script>';
            }
        
    
}

        
?>