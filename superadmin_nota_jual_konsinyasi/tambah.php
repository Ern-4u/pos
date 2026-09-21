<?php
require_once '../database/config.php';

if (isset($_POST['btn_tambah'])) {
    $kode_nota      = trim(mysqli_real_escape_string($conn, $_POST['kode_nota']));
    $id_suplier     = trim(mysqli_real_escape_string($conn, $_POST['id_suplier']));
    $tgl_penjualan  = trim(mysqli_real_escape_string($conn, $_POST['tgl_penjualan']));
    $total_penjualan= trim(mysqli_real_escape_string($conn, $_POST['total_penjualan']));
    $status         = trim(mysqli_real_escape_string($conn, $_POST['status']));
    $keterangan     = trim(mysqli_real_escape_string($conn, $_POST['keterangan']));

    $cek = mysqli_query($conn, "SELECT kode_nota FROM nota_jual_konsinyasi WHERE kode_nota = '$kode_nota'")
           or die(mysqli_error($conn));

    if (mysqli_num_rows($cek) > 0) {
        echo '<script> alert("Kode Nota Sudah Terdaftar! Gunakan kode lain.");
        window.location.href="index.php" </script>';
    } else {
        $query_simpan = mysqli_query($conn, "INSERT INTO nota_jual_konsinyasi
            (kode_nota, id_suplier, tgl_penjualan, total_penjualan, status, keterangan)
            VALUES
            ('$kode_nota', '$id_suplier', '$tgl_penjualan', '$total_penjualan', '$status', '$keterangan')")
        or die(mysqli_error($conn));

        if ($query_simpan) {
            echo '<script> alert("Data Berhasil Disimpan");
            window.location.href="index.php" </script>';
        } else {
            echo '<script> alert("Data Gagal Disimpan");
            window.location.href="index.php" </script>';
        }
    }
}
?>

