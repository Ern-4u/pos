

<?php
require_once '../database/config.php';


if (isset($_POST['btn_tambah'])) {
    $kode_nota = trim(mysqli_real_escape_string($conn, $_POST['kode_nota']));
    $kode_barang = trim(mysqli_real_escape_string($conn, $_POST['kode_barang']));
    $jumlah = trim(mysqli_real_escape_string($conn, $_POST['jumlah']));
    $harga_jual = trim(mysqli_real_escape_string($conn, $_POST['harga_jual']));
    $total_harga_jual= $jumlah * $harga_jual;

    $query_stok = mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang='$kode_barang'") or die(mysqli_error($conn));
    $stok = mysqli_fetch_array($query_stok);

    $total_stok = $stok['stok'] - $jumlah ;

    $query_total_harga = mysqli_query($conn, "SELECT total_penjualan FROM nota_jual WHERE kode_nota='$kode_nota'") or die(mysqli_error($conn));
    $total_transaksi_lama = mysqli_fetch_array($query_total_harga);

    $total_transaksi_baru = $total_transaksi_lama['total_penjualan'] + $total_harga_jual;
    
            $query_simpan = mysqli_query($conn, "INSERT INTO detail_nota_jual 
            (
            kode_nota,
            kode_barang,
            jumlah,
            harga_jual,
            total_harga_jual
            )
            VALUES 
            ('$kode_nota',
            '$kode_barang',
            '$jumlah',
            '$harga_jual',
            '$total_harga_jual'
            )
            ") or die (mysqli_error($conn)) ;

            $query_update = mysqli_query($conn, "UPDATE barang SET stok = '$total_stok' WHERE kode_barang= '$kode_barang'")
            or die(mysqli_error($conn));

            $query_update = mysqli_query($conn, "UPDATE nota_jual SET total_penjualan = '$total_transaksi_baru' WHERE kode_nota= '$kode_nota'")
            or die(mysqli_error($conn));

            if ($query_simpan){
            ?> <script> alert("Data Berhasil Di Tambah"); 
            window.location.href="../superadmin_detail_nota_jual/?kode_nota=<?= $kode_nota ?>" </script> <?php ;
            } else {
              ?> <script> alert("Data Gagal Di Tambah"); 
            window.location.href="../superadmin_detail_nota_jual/?kode_nota=<?= $kode_nota ?> " </script> <?php ;
            }
}



?>