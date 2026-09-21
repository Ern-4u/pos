<?php
require_once '../database/config.php';

if (isset($_POST['btn_edit'])) {
    $kode_nota       = trim(mysqli_real_escape_string($conn, $_POST['kode_nota']));
    $id_suplier      = trim(mysqli_real_escape_string($conn, $_POST['id_suplier']));
    $total_penjualan = trim(mysqli_real_escape_string($conn, $_POST['total_penjualan']));
    $tgl_penjualan   = trim(mysqli_real_escape_string($conn, $_POST['tgl_penjualan']));
    $status          = trim(mysqli_real_escape_string($conn, $_POST['status']));
    $keterangan      = trim(mysqli_real_escape_string($conn, $_POST['keterangan']));

    $query_update = mysqli_query($conn, "UPDATE nota_jual_konsinyasi
        SET 
        id_suplier      = '$id_suplier',
        total_penjualan = '$total_penjualan',
        tgl_penjualan   = '$tgl_penjualan',
        status          = '$status',
        keterangan      = '$keterangan'
        WHERE kode_nota = '$kode_nota'")
    or die(mysqli_error($conn));

    if ($query_update) {
        echo '<script> alert("Data Berhasil Di Edit");
        window.location.href="index.php" </script>';
    } else {
        echo '<script> alert("Data Gagal Di Edit");
        window.location.href="index.php" </script>';
    }
}
?>

