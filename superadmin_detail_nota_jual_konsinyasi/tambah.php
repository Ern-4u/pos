<?php
require_once '../database/config.php';

if (isset($_POST['btn_tambah'])) {
    $kode_nota            = trim(mysqli_real_escape_string($conn, $_POST['kode_nota']));
    $kode_barang          = trim(mysqli_real_escape_string($conn, $_POST['kode_barang_konsinyasi']));
    $jumlah               = (int) trim($_POST['jumlah']);
    $harga_jual           = (float) trim($_POST['harga_jual']);
    $total_harga_jual     = $jumlah * $harga_jual;

    // Cek stok barang konsinyasi
    $q_stok = mysqli_query($conn, "SELECT stok FROM barang_konsinyasi WHERE kode_barang_konsinyasi = '$kode_barang'")
              or die(mysqli_error($conn));
    $row_stok = mysqli_fetch_assoc($q_stok);

    if (!$row_stok || $row_stok['stok'] < $jumlah) {
        echo '<script> alert("Stok barang tidak mencukupi!");
        window.location.href="../superadmin_detail_nota_jual_konsinyasi/?kode_nota=' . $kode_nota . '" </script>';
        exit;
    }

    // Kurangi stok
    $stok_baru = $row_stok['stok'] - $jumlah;
    mysqli_query($conn, "UPDATE barang_konsinyasi SET stok = '$stok_baru' WHERE kode_barang_konsinyasi = '$kode_barang'")
    or die(mysqli_error($conn));

    // Update total penjualan di header nota
    $q_total = mysqli_query($conn, "SELECT total_penjualan FROM nota_jual_konsinyasi WHERE kode_nota = '$kode_nota'")
               or die(mysqli_error($conn));
    $row_total = mysqli_fetch_assoc($q_total);
    $total_baru = $row_total['total_penjualan'] + $total_harga_jual;

    mysqli_query($conn, "UPDATE nota_jual_konsinyasi SET total_penjualan = '$total_baru' WHERE kode_nota = '$kode_nota'")
    or die(mysqli_error($conn));

    // Insert detail
    $query_simpan = mysqli_query($conn, "INSERT INTO detail_nota_jual_konsinyasi
        (kode_nota, kode_barang_konsinyasi, jumlah, harga_jual, total_harga_jual)
        VALUES
        ('$kode_nota', '$kode_barang', '$jumlah', '$harga_jual', '$total_harga_jual')")
    or die(mysqli_error($conn));

    if ($query_simpan) {
        echo '<script> alert("Item Berhasil Ditambahkan");
        window.location.href="../superadmin_detail_nota_jual_konsinyasi/?kode_nota=' . $kode_nota . '" </script>';
    } else {
        echo '<script> alert("Item Gagal Ditambahkan");
        window.location.href="../superadmin_detail_nota_jual_konsinyasi/?kode_nota=' . $kode_nota . '" </script>';
    }
}
?>

