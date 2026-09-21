<?php
require_once '../database/config.php';

if (isset($_POST['btn_foto'])) {

    $kode_barang = trim(mysqli_real_escape_string($conn, $_POST['kode_barang']));
    $file = $_FILES['foto']['name'];
    $ekstensi = explode('.', $file);
    $nama_file = 'barang'.round(microtime(true)).'.'.end($ekstensi);

    $alamat_tujuan = '../assets/foto_barang/'.$nama_file;
    $file_alamat_sumber = $_FILES['foto']['tmp_name'];

    move_uploaded_file($file_alamat_sumber, $alamat_tujuan);

    $query_foto = mysqli_query($conn, "UPDATE barang SET foto_barang = '$nama_file' WHERE kode_barang = '$kode_barang'") or die(mysqli_error($conn));
    if  ($query_foto) {

    echo '<script> alert("Foto Berhasil disimpan");
    window.location.href="index.php" </script>';

    } else {
        echo '<script> alert("Foto Gagal disimpan");
    window.location.href="index.php" </script>';
    }

}
?>