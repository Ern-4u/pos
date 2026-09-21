<?php
require_once '../database/config.php';

if (isset($_POST['btn_edit'])) {
    $id                  = (int) trim($_POST['id']);
    $kode_nota           = trim(mysqli_real_escape_string($conn, $_POST['kode_nota']));
    $kode_barang         = trim(mysqli_real_escape_string($conn, $_POST['kode_barang_konsinyasi']));
    $jumlah_baru         = (int) trim($_POST['jumlah']);
    $harga_jual          = (float) trim($_POST['harga_jual']);
    $total_harga_jual    = (float) trim($_POST['total_harga_jual']);

    // Ambil data lama untuk hitung selisih stok
    $q_lama = mysqli_query($conn, "SELECT * FROM detail_nota_jual_konsinyasi WHERE id = '$id'")
              or die(mysqli_error($conn));
    $lama = mysqli_fetch_assoc($q_lama);

    $selisih_jumlah = $jumlah_baru - $lama['jumlah'];
    $selisih_total  = $total_harga_jual - $lama['total_harga_jual'];

    // Update stok barang konsinyasi (kurangi jika tambah jumlah, kembalikan jika kurang)
    mysqli_query($conn, "UPDATE barang_konsinyasi 
        SET stok = stok - '$selisih_jumlah' 
        WHERE kode_barang_konsinyasi = '$kode_barang'")
    or die(mysqli_error($conn));

    // Update total di header nota
    mysqli_query($conn, "UPDATE nota_jual_konsinyasi 
        SET total_penjualan = total_penjualan + '$selisih_total'
        WHERE kode_nota = '$kode_nota'")
    or die(mysqli_error($conn));

    // Update detail
    $query_update = mysqli_query($conn, "UPDATE detail_nota_jual_konsinyasi
        SET jumlah           = '$jumlah_baru',
            harga_jual       = '$harga_jual',
            total_harga_jual = '$total_harga_jual'
        WHERE id = '$id'")
    or die(mysqli_error($conn));

    if ($query_update) {
        echo '<script> alert("Data Berhasil Di Edit");
        window.location.href="../superadmin_detail_nota_jual_konsinyasi/?kode_nota=' . $kode_nota . '" </script>';
    } else {
        echo '<script> alert("Data Gagal Di Edit");
        window.location.href="../superadmin_detail_nota_jual_konsinyasi/?kode_nota=' . $kode_nota . '" </script>';
    }
}
?>

